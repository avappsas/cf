<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Contrato
 *
 * @property $Id
 * @property $No_Documento
 * @property $Estado
 * @property $Tipo_Contrato
 * @property $Num_Contrato
 * @property $Objeto
 * @property $Actividades
 * @property $Plazo
 * @property $Valor_Total
 * @property $Cuotas
 * @property $Cuotas_Letras
 * @property $Oficina
 * @property $CDP
 * @property $Fecha_CDP
 * @property $Apropiacion
 * @property $Interventor
 * @property $Fecha_Estudios
 * @property $Fecha_Idoneidad
 * @property $Fecha_Notificacion
 * @property $Fecha_Suscripcion
 * @property $RPC
 * @property $Fecha_Invitacion
 * @property $Cargo_Interventor
 * @property $Valor_Total_letras
 * @property $Valor_Mensual
 * @property $Valor_Mensual_Letras
 * @property $N_C
 * @property $Fecha_Venc_CDP
 * @property $Nivel
 * @property $Id_Dp
 * @property $Valor_Cuota_1
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Contrato extends Model
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
    protected $fillable = ['Id','No_Documento','Estado','Tipo_Contrato','Num_Contrato','Objeto','Actividades','Plazo','Valor_Total','Cuotas','Cuotas_Letras','Oficina','CDP','Fecha_CDP','Apropiacion','Interventor','Fecha_Estudios','Fecha_Idoneidad','Fecha_Notificacion','Fecha_Suscripcion','RPC','Fecha_Invitacion','Cargo_Interventor','Valor_Total_letras','Valor_Mensual','Valor_Mensual_Letras','N_C','Fecha_Venc_CDP','Nivel','Id_Dp','Valor_Cuota_1'];



}
