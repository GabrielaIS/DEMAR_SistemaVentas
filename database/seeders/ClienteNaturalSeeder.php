<?php

namespace Database\Seeders;

use App\Models\ClienteNatural;
use Illuminate\Database\Seeder;

class ClienteNaturalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = [
            [
                'documento' => '45127896',
                'nombre' => 'Mariana Torres Silva',
                'nombres_apellidos' => 'Mariana Torres Silva',
                'telefono' => '987654321',
                'tipo' => 'natural',
            ],
            [
                'documento' => '74859612',
                'nombre' => 'Luis Alberto Ramos Perez',
                'nombres_apellidos' => 'Luis Alberto Ramos Perez',
                'telefono' => '912345678',
                'tipo' => 'natural',
            ],
            [
                'documento' => '60321458',
                'nombre' => 'Camila Andrea Rojas Vega',
                'nombres_apellidos' => 'Camila Andrea Rojas Vega',
                'telefono' => '956123789',
                'tipo' => 'natural',
            ],
        ];

        foreach ($clientes as $cliente) {
            ClienteNatural::updateOrCreate(
                ['documento' => $cliente['documento']],
                $cliente
            );
        }
    }
}
