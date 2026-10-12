<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reparacion extends Model
{
    // 👇 AGREGA ESTA LÍNEA 👇
    protected $table = 'reparaciones';

    protected $guarded = [];
    
    // Castear fechas correctamente
    protected $casts = [
        'fecha_ingreso' => 'datetime',
        'fecha_entrega' => 'datetime',
    ];

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    // Método helper para saber qué color de etiqueta usar en la vista
    public function getEstadoColorAttribute()
    {
        return match($this->estado) {
            'recepcion' => 'bg-gray-200 text-gray-800',
            'diagnostico' => 'bg-yellow-200 text-yellow-800',
            'cotizacion' => 'bg-purple-200 text-purple-800',
            'esperando_piezas' => 'bg-orange-200 text-orange-800',
            'en_reparacion' => 'bg-blue-200 text-blue-800',
            'pruebas' => 'bg-indigo-200 text-indigo-800',
            'listo_entrega' => 'bg-green-200 text-green-800',
            'entregado' => 'bg-gray-800 text-white',
            default => 'bg-gray-100',
        };
    }
}