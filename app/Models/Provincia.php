<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Provincia
 *
 * @property $Id
 * @property $Provincia
 * @property $Pais
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Provincia extends Model
{
        // Desactivar los timestamps
        public $timestamps = false;
        
    static $rules = [
		'id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id','provincia','pais'];



}
