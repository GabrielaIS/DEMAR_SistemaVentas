<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class ClienteJuridico extends Cliente
{
    protected static function booted(): void
    {
        static::addGlobalScope('juridico', function (Builder $builder) {
            $builder->where('tipo', 'juridico');
        });

        static::creating(function (ClienteJuridico $cliente) {
            $cliente->tipo = 'juridico';
            $cliente->nombre = $cliente->razon_social ?? $cliente->nombre;
        });

        static::saving(function (ClienteJuridico $cliente) {
            $cliente->tipo = 'juridico';
            $cliente->nombre = $cliente->razon_social ?? $cliente->nombre;
        });
    }
}
