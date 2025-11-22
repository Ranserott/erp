<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'rut',
        'telefono',
        'email',
        'direccion',
        'tipo_rubro',
        'notas'
    ];

    public function calendarioPagos(): HasMany
    {
        return $this->hasMany(CalendarioPago::class, 'proveedor_id');
    }
}
