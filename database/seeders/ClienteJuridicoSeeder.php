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
                'razon_social' => 'Boutique Arena SAC',
                'telefono' => '987654321',
            ],
            [
                'documento' => '20478963215',
                'razon_social' => 'Regalos Lima Norte EIRL',
                'telefono' => '945612378',
            ],
            [
                'documento' => '20145896327',
                'razon_social' => 'Distribuidora Azul Marino SAC',
                'telefono' => '956123789',
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
