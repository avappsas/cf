<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cuota
 *
 * @property $Id
 * @property $Contrato
 * @property $Cuota
 * @property $Fecha_Acta
 * @property $Porcentaje
 * @property $Actividades
 * @property $Planilla
 * @property $Perioro_Planilla
 * @property $Parcial
 * @property $Mes_cobro
 * @property $Oficina
 * @property $Pin_planilla
 * @property $Operador_planilla
 * @property $Fecha_pago_planilla
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Cuota extends Model
{
    
    static $rules = [
		'Id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['Id','Contrato','Cuota','Fecha_Acta','Porcentaje','Actividades','Planilla','Perioro_Planilla','Parcial','Mes_cobro','Oficina','Pin_planilla','Operador_planilla','Fecha_pago_planilla','Actividades_pp','Actividades_tp'];



}
