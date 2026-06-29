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
                'contacto' => 'compras@boutiquearena.pe',
            ],
            [
                'documento' => '20478963215',
                'razon_social' => 'Regalos Lima Norte EIRL',
                'contacto' => '945612378',
            ],
            [
                'documento' => '20145896327',
                'razon_social' => 'Distribuidora Azul Marino SAC',
                'contacto' => 'ventas@azulmarino.pe',
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
