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
    protected $table = 'Base_Datos';
    
    static $rules = [
    ];
    protected $casts = [
        'Fecha_Nacimiento' => 'date',
    ];
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */

 
    protected $fillable = [
        'Tipo_Doc','Documento','Nombre','Fecha_Nacimiento','Telefono','Celular',
        'Direccion','Referido','Observacion','Profesion','Correo','Dv',
        'correo_secop','Nivel_estudios','Perfil','Genero','firma','Municipio','RST',
        'actividad_principal','actividad_secundaria','actividad_contractual','renta','iva'
    ];


}
