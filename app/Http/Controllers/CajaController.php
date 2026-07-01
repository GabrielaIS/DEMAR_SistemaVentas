<?php

namespace App\Http\Controllers;

use App\Models\ClienteJuridico;
use App\Models\ClienteNatural;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CajaController extends Controller
{
    public function index()
    {
        if (! Auth::check()) {
            return redirect()->route('sistema.login');
        }

        if ((Auth::user()->rol ?? null) !== 'cajero') {
            return redirect()->route('admin');
        }

        $products = Producto::where('stock', '>', 0)->get();
        $clientesNaturales = ClienteNatural::orderBy('nombres_apellidos')->get();
        $clientesJuridicos = ClienteJuridico::orderBy('razon_social')->get();
        $clientesNaturalesJson = $clientesNaturales->map(function ($client) {
            return [
                'documento' => $client->documento,
                'nombre' => $client->nombres_apellidos,
                'telefono' => $client->telefono,
            ];
        })->values();
        $clientesJuridicosJson = $clientesJuridicos->map(function ($client) {
            return [
                'documento' => $client->documento,
                'nombre' => $client->razon_social,
                'telefono' => $client->telefono,
            ];
        })->values();

        return view('caja', compact(
            'products',
            'clientesNaturales',
            'clientesJuridicos',
            'clientesNaturalesJson',
            'clientesJuridicosJson'
        ));
    }

    public function vender(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('sistema.login');
        }

        if ((Auth::user()->rol ?? null) !== 'cajero') {
            return redirect()->route('admin');
        }

        $request->merge([
            'telefono' => $request->filled('telefono')
                ? $request->input('telefono')
                : $request->input('telefono_juridico'),
        ]);

        $request->validate([
            'products' => 'nullable|array',
            'payment_method' => 'nullable|string',
            'cash_received' => 'nullable|numeric|min:0',
            'tipo_comprobante' => 'required|in:boleta,factura',
            'documento_cliente' => 'nullable|digits_between:8,11',
            'nombres_apellidos' => 'nullable|string|max:255',
            'razon_social' => 'nullable|string|max:255',
            'telefono_comprobante' => 'nullable|string|max:30',
            'telefono' => 'nullable|string|max:30',
            'telefono_juridico' => 'nullable|string|max:30',
        ]);

        $selected = $request->input('products', []);
        $items = [];
        $productsToUpdate = [];
        $total = 0;

        foreach ($selected as $id => $data) {
            $qty = (int) ($data['quantity'] ?? 0);
            if ($qty <= 0) {
                continue;
            }

            $prod = Producto::find($id);
            if (! $prod) {
                continue;
            }

            $items[] = [
                'producto_id' => $prod->id,
                'nombre' => $prod->nombre,
                'cantidad' => $qty,
                'precio' => $prod->precio,
            ];
            $productsToUpdate[] = [$prod, $qty];

            $total += ($prod->precio * $qty);
        }

        if (empty($items)) {
            return back()->withErrors(['products' => 'Selecciona al menos un producto con cantidad.']);
        }

        $paymentMethod = $request->input('payment_method', 'efectivo');
        $cashReceived = null;
        $cashChange = null;

        if ($paymentMethod === 'efectivo') {
            $request->validate([
                'cash_received' => 'required|numeric|min:'.$total,
            ], [
                'cash_received.required' => 'Ingresa con cuanto pago el cliente.',
                'cash_received.min' => 'El monto recibido no puede ser menor al total.',
            ]);

            $cashReceived = (float) $request->input('cash_received');
            $cashChange = round($cashReceived - $total, 2);
        }

        $clienteId = null;
        $tipoComprobante = $request->input('tipo_comprobante', 'boleta');
        $telefonoEnvio = null;

        if ($total > 700) {
            $documento = (string) $request->input('documento_cliente');

            if ($tipoComprobante === 'boleta') {
                $request->validate([
                    'documento_cliente' => 'required|digits:8',
                ]);

                $cliente = ClienteNatural::withoutGlobalScopes()
                    ->where('tipo', 'natural')
                    ->where('documento', $documento)
                    ->first();

                if (! $cliente) {
                    $data = $request->validate([
                        'nombres_apellidos' => 'required|string|max:255',
                        'telefono' => 'required|string|max:30',
                    ]);

                    $cliente = ClienteNatural::create([
                        'documento' => $documento,
                        'nombres_apellidos' => $data['nombres_apellidos'],
                        'telefono' => $data['telefono'],
                    ]);
                }

                $clienteId = $cliente->id;
            }

            if ($tipoComprobante === 'factura') {
                $request->validate([
                    'documento_cliente' => 'required|digits:11',
                ]);

                $cliente = ClienteJuridico::withoutGlobalScopes()
                    ->where('tipo', 'juridico')
                    ->where('documento', $documento)
                    ->first();

                if (! $cliente) {
                    $data = $request->validate([
                        'razon_social' => 'required|string|max:255',
                        'telefono' => 'required|string|max:30',
                    ]);

                    $cliente = ClienteJuridico::create([
                        'documento' => $documento,
                        'razon_social' => $data['razon_social'],
                        'telefono' => $data['telefono'],
                    ]);
                }

                $clienteId = $cliente->id;
            }
        } else {
            $data = $request->validate([
                'telefono_comprobante' => 'required|string|max:30',
            ], [
                'telefono_comprobante.required' => 'Ingresa el celular para enviar el comprobante por WhatsApp.',
            ]);

            $telefonoEnvio = $data['telefono_comprobante'];
        }

        $venta = DB::transaction(function () use ($clienteId, $items, $total, $tipoComprobante, $paymentMethod, $productsToUpdate) {
            $venta = Venta::create([
                'cliente_id' => $clienteId,
                'usuario_id' => Auth::id(),
                'items' => json_encode($items),
                'total' => $total,
                'metodo_pago' => $paymentMethod,
                'tipo_comprobante' => $tipoComprobante,
                'estado' => 'completada',
            ]);

            foreach ($productsToUpdate as [$prod, $qty]) {
                $prod->stock = max(0, $prod->stock - $qty);
                $prod->save();
            }

            return $venta;
        });

        $receiptClient = null;

        if ($clienteId && isset($cliente)) {
            if ($tipoComprobante === 'boleta') {
                $receiptClient = [
                    'tipo' => 'natural',
                    'nombre' => $cliente->nombres_apellidos,
                    'documento' => $cliente->documento,
                    'telefono' => $cliente->telefono,
                ];
            }

            if ($tipoComprobante === 'factura') {
                $receiptClient = [
                    'tipo' => 'juridico',
                    'razon_social' => $cliente->razon_social,
                    'documento' => $cliente->documento,
                    'telefono' => $cliente->telefono,
                ];
            }
        }

        return redirect()->route('caja')
            ->with('success', 'Venta registrada correctamente.')
            ->with('receipt', [
                'id' => $venta->id,
                'serie' => $tipoComprobante === 'boleta' ? 'B001' : 'F001',
                'numero' => str_pad((string) $venta->id, 6, '0', STR_PAD_LEFT),
                'tipo_comprobante' => $tipoComprobante,
                'cliente' => $receiptClient,
                'telefono_envio' => $telefonoEnvio,
                'items' => $items,
                'total' => $total,
                'metodo_pago' => $paymentMethod,
                'monto_pagado' => $cashReceived,
                'vuelto' => $cashChange,
                'fecha' => now()->format('d/m/Y H:i:s'),
            ]);
    }
}
