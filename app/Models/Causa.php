<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Causa
 *
 * @property $Id
 * @property $id_ramo
 * @property $Causa
 *
 * @property Causa $causa
 * @property Causa $causa
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Causa extends Model
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
    protected $fillable = [ 'id','id_ramo','causa'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function causa()
    {
        return $this->hasOne('App\Models\Causa', 'PK_causa', 'id');
    }
    

    

}
