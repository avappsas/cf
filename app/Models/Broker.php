<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Broker
 *
 * @property int $id               // ID autoincremental
 * @property string $Broker        // Nombre del Broker
 * @property string $campo1        // Campo adicional
 * @property \Carbon\Carbon $created_at // Fecha de creación
 * @property \Carbon\Carbon $updated_at // Fecha de actualización
 *
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Broker extends Model
{
    static $rules = [
        'broker' => 'required|string|max:255|unique:brokers,Broker'
    ];

    static $messages = [
        'broker.required' => 'El nombre del Broker es obligatorio',
        'broker.unique' => 'Este Broker ya existe en el sistema'
    ];

    protected $perPage = 20;
    public $timestamps = false;

    protected $table = 'brokers'; // ✅ si prefieres ser claro

    protected $fillable = [
        'broker', 
        'observacion'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
