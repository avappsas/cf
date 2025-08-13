<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FechaCuentum
 *
 * @property $id
 * @property $id_dp
 * @property $Fecha_max
 * @property $fecha_cuenta
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class FechaCuentum extends Model
{
    
    static $rules = [
    ];
    
    public $timestamps = false;

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_dp','fecha_max','fecha_cuenta'];



}
