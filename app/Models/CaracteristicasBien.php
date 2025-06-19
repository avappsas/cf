<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaracteristicasBien extends Model
{
    protected $table = 'caracteristicas_bien';

    /* Desactiva timestamps si tu tabla no los tiene */
    public $timestamps = false;

    protected $fillable = ['id_bien','caracteristica','valor'];

    /** Cada característica pertenece a un Bien */
    public function bien()
    {
        return $this->belongsTo(Biene::class, 'id_bien');
        //        └── modelo correcto
    }
}
