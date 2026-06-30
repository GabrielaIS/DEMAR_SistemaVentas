<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminReportViewTest extends TestCase
{
    public function test_admin_view_renders_without_report_variables(): void
    {
        $html = view('admin')->render();

        $this->assertStringContainsString('Reportes', $html);
        $this->assertStringContainsString('Ventas por producto', $html);
    }
}
