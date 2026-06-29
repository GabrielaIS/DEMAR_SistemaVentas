<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('tipo')->default('natural')->after('id')->index();
            $table->string('documento', 11)->nullable()->unique()->after('tipo');
            $table->string('nombres_apellidos')->nullable()->after('nombre');
            $table->string('razon_social')->nullable()->after('nombres_apellidos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropUnique(['documento']);
            $table->dropColumn([
                'tipo',
                'documento',
                'nombres_apellidos',
                'razon_social',
            ]);
        });
    }
};
