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
                'nombres_apellidos' => 'Mariana Torres Silva',
                'telefono' => '987654321',
            ],
            [
                'documento' => '74859612',
                'nombres_apellidos' => 'Luis Alberto Ramos Perez',
                'telefono' => '912345678',
            ],
            [
                'documento' => '60321458',
                'nombres_apellidos' => 'Camila Andrea Rojas Vega',
                'telefono' => '956123789',
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
