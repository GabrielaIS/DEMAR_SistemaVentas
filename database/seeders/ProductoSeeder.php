<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            [
                'nombre' => 'Collar Perla Marina',
                'descripcion' => 'Collar artesanal con acabado elegante para uso diario.',
                'precio' => 45.00,
                'stock' => 12,
                'imagen' => 'collares/collar1.png',
                'categoria' => 'collar',
            ],
            [
                'nombre' => 'Collar Dorado Minimal',
                'descripcion' => 'Collar de estilo minimalista con detalle dorado.',
                'precio' => 39.90,
                'stock' => 10,
                'imagen' => 'collares/collar2.jpeg',
                'categoria' => 'collar',
            ],
            [
                'nombre' => 'Collar Cristal Azul',
                'descripcion' => 'Collar con detalle de cristal para ocasiones especiales.',
                'precio' => 52.50,
                'stock' => 8,
                'imagen' => 'collares/collar3.jpeg',
                'categoria' => 'collar',
            ],
            [
                'nombre' => 'Collar Corazon DEMAR',
                'descripcion' => 'Collar delicado con dije de corazon.',
                'precio' => 48.00,
                'stock' => 9,
                'imagen' => 'collares/collar4.jpeg',
                'categoria' => 'collar',
            ],
            [
                'nombre' => 'Collar Luna Fina',
                'descripcion' => 'Collar con dije lunar y acabado brillante.',
                'precio' => 55.00,
                'stock' => 7,
                'imagen' => 'collares/collar5.png',
                'categoria' => 'collar',
            ],
            [
                'nombre' => 'Collar Estrella Brillante',
                'descripcion' => 'Collar con dije de estrella para combinar con looks casuales.',
                'precio' => 49.90,
                'stock' => 11,
                'imagen' => 'collares/collar6.png',
                'categoria' => 'collar',
            ],
            [
                'nombre' => 'Collar Elegance',
                'descripcion' => 'Collar elegante con estilo moderno.',
                'precio' => 59.00,
                'stock' => 6,
                'imagen' => 'collares/collar7.png',
                'categoria' => 'collar',
            ],
            [
                'nombre' => 'Pulsera Perlas Naturales',
                'descripcion' => 'Pulsera artesanal con perlas y cierre ajustable.',
                'precio' => 29.90,
                'stock' => 15,
                'imagen' => 'pulseras/pulsera1.jpeg',
                'categoria' => 'pulsera',
            ],
            [
                'nombre' => 'Pulsera Tejida DEMAR',
                'descripcion' => 'Pulsera tejida de estilo casual.',
                'precio' => 24.50,
                'stock' => 18,
                'imagen' => 'pulseras/pulsera2.jpeg',
                'categoria' => 'pulsera',
            ],
            [
                'nombre' => 'Pulsera Cristal Rosa',
                'descripcion' => 'Pulsera con cristales rosados y acabado brillante.',
                'precio' => 34.90,
                'stock' => 13,
                'imagen' => 'pulseras/pulsera3.png',
                'categoria' => 'pulsera',
            ],
            [
                'nombre' => 'Pulsera Dorada Fina',
                'descripcion' => 'Pulsera dorada delicada para uso diario.',
                'precio' => 36.00,
                'stock' => 10,
                'imagen' => 'pulseras/pulsera4.png',
                'categoria' => 'pulsera',
            ],
            [
                'nombre' => 'Pulsera Charm',
                'descripcion' => 'Pulsera con dije decorativo y cierre seguro.',
                'precio' => 32.50,
                'stock' => 12,
                'imagen' => 'pulseras/pulsera5.png',
                'categoria' => 'pulsera',
            ],
            [
                'nombre' => 'Pulsera Ocean',
                'descripcion' => 'Pulsera inspirada en tonos marinos.',
                'precio' => 31.00,
                'stock' => 14,
                'imagen' => 'pulseras/pulsera6.png',
                'categoria' => 'pulsera',
            ],
            [
                'nombre' => 'Pulsera Noche',
                'descripcion' => 'Pulsera elegante con acabado oscuro.',
                'precio' => 38.00,
                'stock' => 9,
                'imagen' => 'pulseras/pulsera7.png',
                'categoria' => 'pulsera',
            ],
            [
                'nombre' => 'Pulsera Brillo Suave',
                'descripcion' => 'Pulsera con brillo sutil para combinar facilmente.',
                'precio' => 35.00,
                'stock' => 11,
                'imagen' => 'pulseras/pulsera8.png',
                'categoria' => 'pulsera',
            ],
            [
                'nombre' => 'Pulsera Classic',
                'descripcion' => 'Pulsera clasica con diseno versatil.',
                'precio' => 33.90,
                'stock' => 16,
                'imagen' => 'pulseras/pulsera9.png',
                'categoria' => 'pulsera',
            ],
        ];

        foreach ($productos as $producto) {
            Producto::updateOrCreate(
                ['nombre' => $producto['nombre']],
                $producto
            );
        }
    }
}
