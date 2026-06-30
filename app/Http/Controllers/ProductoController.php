<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductoController extends Controller
{
    private function checkAdmin()
    {
        if (! Auth::check()) {
            return redirect()->route('sistema.login');
        }

        if ((Auth::user()->rol ?? null) !== 'admin') {
            return redirect()->route('caja');
        }

        return null;
    }

    public function store(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $data = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'categoria'   => 'required|string',
            'imagen'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $this->guardarImagen($request->file('imagen'));
        }

        Producto::create($data);

        return back()->with('success', 'Producto creado correctamente.');
    }

    public function update(Request $request, Producto $producto)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $data = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'categoria'   => 'required|string',
            'imagen'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $this->eliminarImagen($producto->imagen);
            $data['imagen'] = $this->guardarImagen($request->file('imagen'));
        }

        $producto->update($data);

        return back()->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $this->eliminarImagen($producto->imagen);
        $producto->delete();

        return back()->with('success', 'Producto eliminado correctamente.');
    }

    private function guardarImagen($file): string
    {
        $nombreArchivo = uniqid() . '_' . $file->getClientOriginalName();
        $destino = public_path('productos');

        if (! File::exists($destino)) {
            File::makeDirectory($destino, 0755, true);
        }

        $file->move($destino, $nombreArchivo);

        return 'productos/' . $nombreArchivo;
    }

    private function eliminarImagen(?string $ruta): void
    {
        if ($ruta && File::exists(public_path($ruta))) {
            File::delete(public_path($ruta));
        }
    }
}