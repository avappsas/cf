<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoBiene
 *
 * @property int $id
 * @property int $id_bien
 * @property string $tipo
 *
 * @package App\Models
 */
class TipoBiene extends Model
{
    protected $table = 'tipo_bienes';
    public $timestamps = false;

    static $rules = [
    ];
    
    protected $fillable = [
        'id_bien',
        'tipo',
        'caracteristicas',
    ];

 
}
