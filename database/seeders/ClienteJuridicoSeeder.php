<?php

namespace Database\Seeders;

use App\Models\ClienteJuridico;
use Illuminate\Database\Seeder;

class ClienteJuridicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = [
            [
                'documento' => '20605487912',
                'nombre' => 'Boutique Arena SAC',
                'razon_social' => 'Boutique Arena SAC',
                'tipo' => 'juridico',
            ],
            [
                'documento' => '20478963215',
                'nombre' => 'Regalos Lima Norte EIRL',
                'razon_social' => 'Regalos Lima Norte EIRL',
                'tipo' => 'juridico',
            ],
            [
                'documento' => '20145896327',
                'nombre' => 'Distribuidora Azul Marino SAC',
                'razon_social' => 'Distribuidora Azul Marino SAC',
                'tipo' => 'juridico',
            ],
        ];

        foreach ($clientes as $cliente) {
            ClienteJuridico::updateOrCreate(
                ['documento' => $cliente['documento']],
                $cliente
            );
        }
    }
}
