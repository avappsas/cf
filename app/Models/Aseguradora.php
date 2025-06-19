<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Aseguradora
 *
 * @property $id
 * @property $Aseguradora
 * @property $id_ramo
 *
 * @property Aseguradora $aseguradora
 * @property Aseguradora $aseguradora
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Aseguradora extends Model
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
    protected $fillable = ['aseguradora','id_ramo'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    public function aseguradora()
    {
        return $this->hasOne('App\Models\Aseguradora', 'PK_aseguradoras', 'id');
    }
    

}
