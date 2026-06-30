<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminReportViewTest extends TestCase
{
    public function test_admin_view_renders_without_report_variables(): void
    {
        $html = view('admin', [
            'ventas' => collect(),
            'ventasHoyTotal' => 0,
            'ventasMesTotal' => 0,
            'ticketPromedio' => 0,
            'unidadesVendidas' => 0,
            'productosReporte' => collect(),
            'productos' => collect(),
            'usuarios' => collect(),
        ])->render();

        $this->assertStringContainsString('Reportes', $html);
        $this->assertStringContainsString('Ventas por producto', $html);
        $this->assertStringContainsString('Productos', $html);
    }
}
