<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_empresa',
        'rut_cliente',
        'direccion',
        'contacto_nombre',
        'contacto_telefono',
        'contacto_email',
        'notas'
    ];

    // Accessors para compatibilidad con las vistas
    public function getNombreAttribute()
    {
        return $this->contacto_nombre ?? $this->nombre_empresa ?? 'Sin nombre';
    }

    public function getEmailAttribute()
    {
        return $this->contacto_email;
    }

    public function getTelefonoAttribute()
    {
        return $this->contacto_telefono;
    }

    public function cotizaciones(): HasMany
    {
        return $this->hasMany(Cotizacion::class);
    }

    public function ordenesTrabajo(): HasMany
    {
        return $this->hasMany(OrdenTrabajo::class, 'cliente_id');
    }

    public function facturas(): HasMany
    {
        return $this->hasMany(Factura::class);
    }
}
