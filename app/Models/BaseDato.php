<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseDato
 *
 * @property $id
 * @property $Tipo_Doc
 * @property $Documento
 * @property $Nombre
 * @property $Fecha_Nacimiento
 * @property $Telefono
 * @property $Celular
 * @property $Direccion
 * @property $Referido
 * @property $Observacion
 * @property $Profesion
 * @property $Correo
 * @property $Dv
 * @property $correo_secop
 * @property $Nivel_estudios
 * @property $Perfil
 * @property $Genero
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class BaseDato extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id','Tipo_Doc','Documento','Nombre','Fecha_Nacimiento','Telefono','Celular','Direccion','Referido','Observacion','Profesion','Correo','Dv','correo_secop','Nivel_estudios','Perfil','Genero'];



}
