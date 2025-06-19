<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'id_bien',
        'file_path',
        'description',
    ];
}