<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entrega extends Model
{
    use HasFactory;

    protected $table = 'entregas';

    protected $fillable = [
        'numero_entrega',
        'orden_trabajo_id',
        'cliente_id',
        'user_id',
        'fecha_entrega',
        'nombre_receptor',
        'documento_receptor',
        'direccion_entrega',
        'telefono_receptor',
        'estado',
        'observaciones',
        'evidencia_foto',
        'firma_digital',
        'tipo_entrega',
        'metodo_entrega',
        'notas_internas'
    ];

    protected $casts = [
        'fecha_entrega' => 'date',
        'evidencia_foto' => 'array',
        'firma_digital' => 'array'
    ];

    // Estados posibles
    const ESTADOS = [
        'pendiente' => 'Pendiente',
        'en_camino' => 'En Camino',
        'entregado' => 'Entregado',
        'rechazado' => 'Rechazado',
        'devuelto' => 'Devuelto',
        'cancelado' => 'Cancelado'
    ];

    // Tipos de entrega
    const TIPOS_ENTREGA = [
        'completa' => 'Completa',
        'parcial' => 'Parcial',
        'entrega_final' => 'Entrega Final'
    ];

    // Métodos de entrega
    const METODOS_ENTREGA = [
        'propia' => 'Transporte Propio',
        'externa' => 'Transporte Externo',
        'digital' => 'Entrega Digital',
        'retiro' => 'Retiro en Sucursal'
    ];

    public function ordenTrabajo(): BelongsTo
    {
        return $this->belongsTo(OrdenTrabajo::class, 'orden_trabajo_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Accessors para compatibilidad
    public function getNombreAttribute()
    {
        return $this->numero_entrega;
    }

    public function getEstadoLabelAttribute()
    {
        return self::ESTADOS[$this->estado] ?? $this->estado;
    }

    public function getTipoEntregaLabelAttribute()
    {
        return self::TIPOS_ENTREGA[$this->tipo_entrega] ?? $this->tipo_entrega;
    }

    public function getMetodoEntregaLabelAttribute()
    {
        return self::METODOS_ENTREGA[$this->metodo_entrega] ?? $this->metodo_entrega;
    }

    public function getEstadoColorAttribute()
    {
        $colors = [
            'pendiente' => 'yellow',
            'en_camino' => 'blue',
            'entregado' => 'green',
            'rechazado' => 'red',
            'devuelto' => 'orange',
            'cancelado' => 'gray'
        ];
        return $colors[$this->estado] ?? 'gray';
    }

    public function getEstaVencidaAttribute()
    {
        return $this->fecha_entrega &&
               $this->fecha_entrega->isPast() &&
               $this->estado !== 'entregado' &&
               $this->estado !== 'cancelado';
    }

    public function getNombreCompletoAttribute()
    {
        $cliente = $this->cliente;
        if ($cliente) {
            return $cliente->nombre;
        }

        $ot = $this->ordenTrabajo;
        if ($ot && $ot->cliente) {
            return $ot->cliente->nombre;
        }

        return 'Cliente no especificado';
    }
}
