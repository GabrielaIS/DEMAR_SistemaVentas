<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('clientes', 'contacto')) {
            return;
        }

        DB::table('clientes')
            ->where(function ($query) {
                $query->whereNull('telefono')
                    ->orWhere('telefono', '');
            })
            ->whereNotNull('contacto')
            ->orderBy('id')
            ->get(['id', 'contacto'])
            ->each(function ($cliente) {
                $telefono = preg_replace('/\D+/', '', (string) $cliente->contacto);

                if (strlen($telefono) >= 7) {
                    DB::table('clientes')
                        ->where('id', $cliente->id)
                        ->update(['telefono' => $telefono]);
                }
            });

        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('contacto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('clientes', 'contacto')) {
            return;
        }

        Schema::table('clientes', function (Blueprint $table) {
            $table->string('contacto')->nullable()->after('telefono');
        });
    }
};
