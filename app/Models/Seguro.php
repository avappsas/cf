<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Seguro
 *
 * @property $id
 * @property $seguro
 *
 * @property Seguro $seguro
 * @property Seguro $seguro
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Seguro extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['seguro'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */


     public $timestamps = false;
     
    public function seguro()
    {
        return $this->hasOne('App\Models\Seguro', 'PK_Seguros', 'id');
    }
    

    

}
