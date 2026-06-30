<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user && ($user->rol ?? null) === 'admin') {
                return redirect()->route('admin');
            }

            if ($user && ($user->rol ?? null) === 'cajero') {
                return redirect()->route('caja');
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Tu usuario no tiene un rol autorizado.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Credenciales invalidas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function admin()
    {
        if (! Auth::check()) {
            return redirect()->route('sistema.login');
        }

        if ((Auth::user()->rol ?? null) !== 'admin') {
            return redirect()->route('caja');
        }

        $ventas = Venta::latest()->get();
        $ventasHoy = Venta::whereDate('created_at', today())->get();
        $ventasMes = Venta::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->get();

        $ventasHoyTotal = $ventasHoy->sum('total');
        $ventasMesTotal = $ventasMes->sum('total');
        $ticketPromedio = $ventasMes->count() > 0 ? round($ventasMesTotal / $ventasMes->count(), 2) : 0;

        $unidadesVendidas = 0;
        $productosReporte = [];

        foreach ($ventas as $venta) {
            $items = json_decode($venta->items, true) ?? [];

            foreach ($items as $item) {
                $cantidad = (int) ($item['cantidad'] ?? 0);
                $precio = (float) ($item['precio'] ?? 0);
                $productoId = $item['producto_id'] ?? null;
                $nombre = $item['nombre'] ?? 'Producto sin nombre';

                $unidadesVendidas += $cantidad;

                $key = $productoId ?? $nombre;
                if (! isset($productosReporte[$key])) {
                    $productosReporte[$key] = [
                        'id' => $productoId,
                        'nombre' => $nombre,
                        'cantidad' => 0,
                        'precio' => 0,
                        'total' => 0,
                    ];
                }

                $productosReporte[$key]['cantidad'] += $cantidad;
                $productosReporte[$key]['precio'] = max($productosReporte[$key]['precio'], $precio);
                $productosReporte[$key]['total'] += round($cantidad * $precio, 2);
            }
        }

        $productosReporte = collect($productosReporte)->values()->sortByDesc('total')->values();

        return view('admin', compact(
            'ventas',
            'ventasHoyTotal',
            'ventasMesTotal',
            'ticketPromedio',
            'unidadesVendidas',
            'productosReporte'
        ));
    }
}
