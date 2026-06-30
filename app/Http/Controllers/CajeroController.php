<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CajeroController extends Controller
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
            'nombre'   => 'required|string|max:255',
            'email'    => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'nombre'   => $data['nombre'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'rol'      => 'cajero',
        ]);

        return back()->with('success', 'Cajero creado correctamente.');
    }

    public function update(Request $request, User $cajero)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        if ($cajero->rol !== 'cajero') {
            return back()->with('error', 'Solo se pueden editar usuarios cajeros.');
        }

        $data = $request->validate([
            'nombre'   => 'required|string|max:255',
            'email'    => ['required', 'email', Rule::unique('usuarios', 'email')->ignore($cajero->id)],
            'password' => 'nullable|string|min:6',
        ]);

        $cajero->nombre = $data['nombre'];
        $cajero->email  = $data['email'];

        if (! empty($data['password'])) {
            $cajero->password = Hash::make($data['password']);
        }

        $cajero->save();

        return back()->with('success', 'Cajero actualizado correctamente.');
    }

    public function destroy(User $cajero)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        if ($cajero->rol !== 'cajero') {
            return back()->with('error', 'Solo se pueden eliminar usuarios cajeros.');
        }

        $cajero->delete();

        return back()->with('success', 'Cajero eliminado correctamente.');
    }
}