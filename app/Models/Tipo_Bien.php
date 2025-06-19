<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Bien extends Model
{
    use HasFactory;

    protected $fillable = ['tipo']; // Ajusta según los campos de tu tabla

}
