<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrdenTrabajo extends Model
{
    use HasFactory;

    protected $table = 'ordenes_trabajo';

    protected $fillable = [
        'numero_ot',
        'cliente_id',
        'cotizacion_id',
        'user_id',
        'descripcion',
        'fecha_inicio',
        'fecha_fin_estimada',
        'fecha_fin_real',
        'prioridad',
        'estado',
        'notas',
        'costo_estimado',
        'costo_real'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin_estimada' => 'date',
        'fecha_fin_real' => 'date',
        'costo_estimado' => 'decimal:2',
        'costo_real' => 'decimal:2'
    ];

    // Estados posibles
    const ESTADOS = [
        'pendiente' => 'Pendiente',
        'en_progreso' => 'En Progreso',
        'pausada' => 'Pausada',
        'completada' => 'Completada',
        'cancelada' => 'Cancelada'
    ];

    // Prioridades posibles
    const PRIORIDADES = [
        'baja' => 'Baja',
        'media' => 'Media',
        'alta' => 'Alta',
        'urgente' => 'Urgente'
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function facturas(): HasMany
    {
        return $this->hasMany(Factura::class, 'orden_trabajo_id');
    }

    public function entregas(): HasMany
    {
        return $this->hasMany(Entrega::class, 'orden_trabajo_id');
    }

    // Accessors para compatibilidad
    public function getNombreAttribute()
    {
        return $this->numero_ot;
    }

    public function getEstadoLabelAttribute()
    {
        return self::ESTADOS[$this->estado] ?? $this->estado;
    }

    public function getPrioridadLabelAttribute()
    {
        return self::PRIORIDADES[$this->prioridad] ?? $this->prioridad;
    }

    public function getEstadoColorAttribute()
    {
        $colors = [
            'pendiente' => 'yellow',
            'en_progreso' => 'blue',
            'pausada' => 'orange',
            'completada' => 'green',
            'cancelada' => 'red'
        ];
        return $colors[$this->estado] ?? 'gray';
    }

    public function getPrioridadColorAttribute()
    {
        $colors = [
            'baja' => 'gray',
            'media' => 'blue',
            'alta' => 'orange',
            'urgente' => 'red'
        ];
        return $colors[$this->prioridad] ?? 'gray';
    }

    public function getDuracionEstimadaAttribute()
    {
        if ($this->fecha_inicio && $this->fecha_fin_estimada) {
            return $this->fecha_inicio->diffInDays($this->fecha_fin_estimada);
        }
        return null;
    }

    public function getEstaAtrasadaAttribute()
    {
        return $this->estado === 'en_progreso' &&
               $this->fecha_fin_estimada &&
               $this->fecha_fin_estimada->isPast();
    }
}
