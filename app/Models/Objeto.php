<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objeto extends Model
{
    use HasFactory;
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
    protected $fillable = ['id','id_ramo', 'descripcion','observacion'];

    protected $table = 'objetos'; // Ajusta al nombre de tu tabla real
}