<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'apellidos',
        'telefono',
        'whatsapp',
        'email',
        'direccion',
        'notas',
    ];

    public function equipos(): HasMany
    {
        return $this->hasMany(Equipo::class);
    }
}