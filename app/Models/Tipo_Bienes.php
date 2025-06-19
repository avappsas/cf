<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo_Bienes extends Model
{
    // Especifica el nombre de la tabla (en caso de que no sea el plural de la clase)
    protected $table = 'tipo_bienes'; // Usamos el nombre exacto de la tabla
    protected $fillable = ['tipo']; // Ajusta según los campos de tu tabla

}