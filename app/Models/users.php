<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'usuario',
        'telefonos',
        'id_provincia', // Asegúrate de incluir este campo
    ];
}
