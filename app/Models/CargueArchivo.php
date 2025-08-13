<?php 
  
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargueArchivo extends Model
{
    protected $table = 'Cargue_Archivo'; // Nombre exacto de la tabla

    protected $primaryKey = 'Id'; // Llave primaria personalizada

    public $timestamps = false; // Ya tienes tus propios campos de fecha

    protected $fillable = [
        'Id_formato',
        'Id_contrato',
        'id_cuota',
        'Ruta',
        'Estado',
        'Observacion',
        'Fecha_creacion',
        'Fecha_actualizacion',
        'id_user',
    ];
}