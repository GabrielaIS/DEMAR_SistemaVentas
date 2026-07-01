<?php

namespace App\Http\Controllers;

use App\Models\ClienteJuridico;
use App\Models\ClienteNatural;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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

    public function consultarDocumento(Request $request)
    {
        if (! Auth::check()) {
            return response()->json(['success' => false, 'message' => 'No autenticado.'], 401);
        }

        if ((Auth::user()->rol ?? null) !== 'cajero') {
            return response()->json(['success' => false, 'message' => 'Acceso denegado.'], 403);
        }

        $request->validate([
            'documento_cliente' => 'required|string',
            'tipo_comprobante' => 'required|in:boleta,factura',
        ]);

        $tipo = $request->input('tipo_comprobante');
        $documento = preg_replace('/\D/', '', (string) $request->input('documento_cliente'));

        try {
            $apiKey = env('APIINTI_API_KEY');
            if (! $apiKey) {
                return response()->json(['success' => false, 'message' => 'API key no configurada.'], 500);
            }

            if ($tipo === 'boleta') {
                if (strlen($documento) !== 8) {
                    return response()->json(['success' => false, 'message' => 'DNI inválido.'], 400);
                }

                $resp = Http::withHeaders([
                    'Authorization' => 'Bearer '.$apiKey,
                ])->accept('application/json')
                  ->get("https://app.apiinti.dev/api/v1/dni/{$documento}");

                if (! $resp->ok()) {
                    return response()->json(['success' => false, 'message' => 'No se pudo consultar DNI.'], $resp->status());
                }

                $body = $resp->json();
                $name = $body['data']['nombreCompleto'] ?? null;
                if (! $name && isset($body['data']['nombres'])) {
                    $name = trim(($body['data']['apellidoPaterno'] ?? '') . ' ' . ($body['data']['apellidoMaterno'] ?? '') . ' ' . ($body['data']['nombres'] ?? ''));
                }

                return response()->json(['success' => true, 'data' => ['nombre' => $name ?? '']]);
            }

            // factura -> RUC
            if ($tipo === 'factura') {
                if (strlen($documento) !== 11) {
                    return response()->json(['success' => false, 'message' => 'RUC inválido.'], 400);
                }

                $resp = Http::withHeaders([
                    'Authorization' => 'Bearer '.$apiKey,
                ])->accept('application/json')
                  ->get("https://app.apiinti.dev/api/v1/ruc/{$documento}");

                if (! $resp->ok()) {
                    return response()->json(['success' => false, 'message' => 'No se pudo consultar RUC.'], $resp->status());
                }

                $body = $resp->json();
                $razon = $body['data']['razonSocial'] ?? ($body['data']['razon_social'] ?? '');
                $direccion = $body['data']['direccion'] ?? '';
                $estado = $body['data']['estado'] ?? '';

                return response()->json(['success' => true, 'data' => [
                    'razon_social' => $razon,
                    'direccion' => $direccion,
                    'estado' => $estado,
                ]]);
            }

            return response()->json(['success' => false, 'message' => 'Tipo de comprobante no soportado.'], 400);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error interno: '.$e->getMessage()], 500);
        }
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
            'card_number' => 'nullable|string',
            'cvv' => 'nullable|string',
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

        if ($paymentMethod === 'tarjeta') {
            $request->merge([
                'card_number' => preg_replace('/\D/', '', (string) $request->input('card_number')),
                'cvv' => preg_replace('/\D/', '', (string) $request->input('cvv')),
            ]);

            $request->validate([
                'card_number' => 'required|digits:16',
                'cvv' => 'required|digits_between:3,4',
            ], [
                'card_number.required' => 'Ingresa el numero de tarjeta.',
                'card_number.digits' => 'El numero de tarjeta debe tener 16 digitos.',
                'cvv.required' => 'Ingresa el CVV de la tarjeta.',
                'cvv.digits_between' => 'El CVV debe tener 3 o 4 digitos.',
            ]);
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
