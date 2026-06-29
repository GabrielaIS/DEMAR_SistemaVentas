<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'tipo',
        'documento',
        'nombre',
        'nombres_apellidos',
        'razon_social',
        'telefono',
    ];

    public function getNombreMostrableAttribute(): string
    {
        return $this->tipo === 'juridico'
            ? (string) ($this->razon_social ?? $this->nombre)
            : (string) ($this->nombres_apellidos ?? $this->nombre);
    }
}
