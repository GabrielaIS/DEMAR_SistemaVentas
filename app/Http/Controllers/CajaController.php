<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $clients = Cliente::orderBy('nombre')->get();

        return view('caja', compact('products', 'clients'));
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
            'client_id' => 'nullable|exists:clientes,id',
            'payment_method' => 'nullable|string',
        ]);

        $selected = $request->input('products', []);
        $items = [];
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

            $total += ($prod->precio * $qty);

            $prod->stock = max(0, $prod->stock - $qty);
            $prod->save();
        }

        if (empty($items)) {
            return back()->withErrors(['products' => 'Selecciona al menos un producto con cantidad.']);
        }

        Venta::create([
            'cliente_id' => $request->input('client_id'),
            'usuario_id' => Auth::id(),
            'items' => json_encode($items),
            'total' => $total,
            'metodo_pago' => $request->input('payment_method', 'efectivo'),
            'estado' => 'completada',
        ]);

        return redirect()->route('caja')->with('success', 'Venta registrada correctamente.');
    }
}
