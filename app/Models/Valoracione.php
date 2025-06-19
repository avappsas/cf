<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Valoracione
 *
 * @property $id
 * @property $id_bien
 * @property $descripcion
 * @property $Cant
 * @property $Valor_Cotizado
 * @property $Valor_Aprobado
 *
 * @property Valoracione $valoracione
 * @property Valoracione $valoracione
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Valoracione extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_bien','descripcion','cant','valor_cotizado','valor_aprobado'];

    public $timestamps = false; // Deshabilita los timestamps

    public function getValorAprobadoAttribute($value)
    {
        return number_format($value, 0, ',', '.'); // Formato sin decimales
    }


     /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function valoraciones()
    {
        return $this->hasMany(Valoracione::class, 'id_bien'); // Relacionar con id_bien
    }
    


    public function bien()
    {
        return $this->belongsTo(Biene::class, 'id_bien');
    }

}
