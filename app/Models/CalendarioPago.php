<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalendarioPago extends Model
{
    use HasFactory;

    protected $table = 'calendario_pagos';

    protected $fillable = [
        'titulo_servicio',
        'descripcion',
        'proveedor_id',
        'monto',
        'fecha_pago',
        'tipo_pago',
        'categoria',
        'recurrente',
        'dias_recordatorio',
        'recordatorio_enviado',
        'estado',
        'notas_internas'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'date',
        'dias_recordatorio' => 'integer',
        'recordatorio_enviado' => 'boolean'
    ];

    // Estados posibles
    const ESTADOS = [
        'pendiente' => 'Pendiente',
        'pagado' => 'Pagado',
        'vencido' => 'Vencido'
    ];

    // Tipos de pago
    const TIPOS_PAGO = [
        'transferencia' => 'Transferencia Bancaria',
        'cheque' => 'Cheque',
        'efectivo' => 'Efectivo',
        'tarjeta' => 'Tarjeta de Crédito/Débito',
        'deposito' => 'Depósito',
        'otro' => 'Otro'
    ];

    // Tipos de recurrencia
    const RECURRENTES = [
        'unico' => 'Único',
        'mensual' => 'Mensual',
        'trimestral' => 'Trimestral',
        'semestral' => 'Semestral',
        'anual' => 'Anual'
    ];

    // Categorías sugeridas
    const CATEGORIAS = [
        'servicios' => 'Servicios',
        'materiales' => 'Materiales',
        'alquiler' => 'Alquiler',
        'seguros' => 'Seguros',
        'suministros' => 'Suministros',
        'mantenimiento' => 'Mantenimiento',
        'software' => 'Software',
        'consultoria' => 'Consultoría',
        'marketing' => 'Marketing',
        'impuestos' => 'Impuestos',
        'nomina' => 'Nómina',
        'otro' => 'Otro'
    ];

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    // Accessors
    public function getEstadoLabelAttribute()
    {
        return self::ESTADOS[$this->estado] ?? $this->estado;
    }

    public function getTipoPagoLabelAttribute()
    {
        return self::TIPOS_PAGO[$this->tipo_pago] ?? $this->tipo_pago;
    }

    public function getRecurrenteLabelAttribute()
    {
        return self::RECURRENTES[$this->recurrente] ?? $this->recurrente;
    }

    public function getCategoriaLabelAttribute()
    {
        return self::CATEGORIAS[$this->categoria] ?? $this->categoria;
    }

    public function getEstaVencidoAttribute()
    {
        return $this->fecha_pago->isPast() && $this->estado !== 'pagado';
    }

    public function getEsProximoAttribute()
    {
        $hoy = now();
        $diasHastaPago = $hoy->diffInDays($this->fecha_pago, false);
        return $diasHastaPago >= 0 && $diasHastaPago <= 7;
    }

    public function getDiasRestantesAttribute()
    {
        if ($this->fecha_pago->isPast()) {
            return abs(now()->diffInDays($this->fecha_pago));
        }
        return now()->diffInDays($this->fecha_pago);
    }

    // Scopes
    public function scopeDelMes($query, $mes = null, $anio = null)
    {
        $mes = $mes ?? now()->month;
        $anio = $anio ?? now()->year;

        return $query->whereMonth('fecha_pago', $mes)
                     ->whereYear('fecha_pago', $anio);
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopePagados($query)
    {
        return $query->where('estado', 'pagado');
    }

    public function scopeVencidos($query)
    {
        return $query->where('fecha_pago', '<', now())
                     ->where('estado', '!=', 'pagado');
    }

    public function scopeProximos($query, $dias = 7)
    {
        return $query->where('fecha_pago', '>=', now())
                     ->where('fecha_pago', '<=', now()->addDays($dias))
                     ->where('estado', '!=', 'pagado');
    }

    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopePorProveedor($query, $proveedorId)
    {
        return $query->where('proveedor_id', $proveedorId);
    }
}
