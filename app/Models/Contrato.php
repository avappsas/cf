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
    ];
    protected $table = 'contratos';
    protected $primaryKey = 'Id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['No_Documento','Estado','Tipo_Contrato','Num_Contrato','Objeto','Actividades','Plazo','Valor_Total','Cuotas','Cuotas_Letras','Oficina','CDP','Fecha_CDP','Apropiacion','Interventor'
    ,'Fecha_Estudios','Fecha_Idoneidad','Fecha_Notificacion','Fecha_Suscripcion','RPC','Fecha_Invitacion','Cargo_Interventor','Valor_Total_letras','Valor_Mensual','Valor_Mensual_Letras','N_C','Fecha_Venc_CDP','Nivel'
    ,'Id_Dp','Valor_Cuota_1','Origen','Año','Iva','id_user','Modalidad','Obs_Contrato','id_estado','Estado_interno','Fecha_Inicio_Contrato','Fecha_Venc_RPC','Fecha_RPC'];

    protected $casts = [
      
      'Plazo'                 => 'date',
      'Fecha_Notificacion'    => 'date',
      'Fecha_Venc_CDP'        => 'date',
      'Fecha_Estudios'        => 'date',
      'Fecha_Invitacion'      => 'date',
      'Fecha_Idoneidad'       => 'date',
      'Fecha_CDP'             => 'date',
      'Fecha_Suscripcion'     => 'date',
      'Fecha_Inicio_Contrato' => 'date',
      'Fecha_Venc_RPC' => 'date',
      'Fecha_RPC' => 'date',
      // etc.
  ];
  public function setValorTotalAttribute($value)
  {
      $this->attributes['Valor_Total'] = (int) preg_replace('/\D+/', '', $value);
  }

  public function setValorMensualAttribute($value)
  {
      $this->attributes['Valor_Mensual'] = (int) preg_replace('/\D+/', '', $value);
  }

  public function setValorCuota1Attribute($value)
  {
      $this->attributes['Valor_Cuota_1'] = (int) preg_replace('/\D+/', '', $value);
  }

  public function oficina()
  {
      // El FK real en tu tabla es N_Oficina
      return $this->belongsTo(Oficina::class, 'N_Oficina', 'Id');
  }

    public function getNumContratoCortoAttribute()
    {
        $partes = explode('.', $this->Num_Contrato);
        return implode('.', array_slice($partes, -2));
    }
//   public function interventor()
//   {
//       // 'Interventor' es la FK en contratos, 'Id' la PK de Interventores
//       return $this->belongsTo(Interventor::class, 'Interventor', 'Id');
//   }

}
