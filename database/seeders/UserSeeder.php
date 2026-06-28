<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuarios')->updateOrInsert(
            ['email' => 'admin@demar.com'],
            [
                'nombre' => 'Administrador',
                'password' => Hash::make('admin123'),
                'rol' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('usuarios')->updateOrInsert(
            ['email' => 'cajero@demar.com'],
            [
                'nombre' => 'Cajero',
                'password' => Hash::make('cajero1234'),
                'rol' => 'cajero',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
