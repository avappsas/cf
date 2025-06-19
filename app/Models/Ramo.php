<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ramo
 *
 * @property $id
 * @property $ramo
 * @property $campo1
 *
 * @property Ramo $ramo
 * @property Ramo $ramo
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Ramo extends Model
{
    // Desactivar los timestamps
    public $timestamps = false;
     
    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['ramo','campo1'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ramo()
    {
        return $this->hasOne('App\Models\Ramo', 'PK_Ramos', 'id');
    }
    

}
