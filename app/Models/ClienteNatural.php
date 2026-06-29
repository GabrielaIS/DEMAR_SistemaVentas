<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class ClienteNatural extends Cliente
{
    protected static function booted(): void
    {
        static::addGlobalScope('natural', function (Builder $builder) {
            $builder->where('tipo', 'natural');
        });

        static::creating(function (ClienteNatural $cliente) {
            $cliente->tipo = 'natural';
            $cliente->nombre = $cliente->nombres_apellidos ?? $cliente->nombre;
        });

        static::saving(function (ClienteNatural $cliente) {
            $cliente->tipo = 'natural';
            $cliente->nombre = $cliente->nombres_apellidos ?? $cliente->nombre;
        });
    }
}
