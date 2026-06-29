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
                'contacto' => $client->contacto,
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

        $request->validate([
            'products' => 'nullable|array',
            'payment_method' => 'nullable|string',
            'tipo_comprobante' => 'required|in:boleta,factura',
            'documento_cliente' => 'nullable|digits_between:8,11',
            'nombres_apellidos' => 'nullable|string|max:255',
            'razon_social' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:30',
            'contacto' => 'nullable|string|max:255',
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

        $clienteId = null;
        $tipoComprobante = $request->input('tipo_comprobante', 'boleta');

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
                        'contacto' => 'required|string|max:255',
                    ]);

                    $cliente = ClienteJuridico::create([
                        'documento' => $documento,
                        'razon_social' => $data['razon_social'],
                        'contacto' => $data['contacto'],
                    ]);
                }

                $clienteId = $cliente->id;
            }
        }

        DB::transaction(function () use ($clienteId, $items, $total, $tipoComprobante, $request, $productsToUpdate) {
            Venta::create([
                'cliente_id' => $clienteId,
                'usuario_id' => Auth::id(),
                'items' => json_encode($items),
                'total' => $total,
                'metodo_pago' => $request->input('payment_method', 'efectivo'),
                'tipo_comprobante' => $tipoComprobante,
                'estado' => 'completada',
            ]);

            foreach ($productsToUpdate as [$prod, $qty]) {
                $prod->stock = max(0, $prod->stock - $qty);
                $prod->save();
            }
        });

        return redirect()->route('caja')->with('success', 'Venta registrada correctamente.');
    }
}
