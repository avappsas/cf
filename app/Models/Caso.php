<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Asegurado;
use App\Models\Aseguradora;

/**
 * Class Caso
 *
 * @property $id
 * @property $id_CFR
 * @property $Aseguradora
 * @property $Ramo
 * @property $Broker
 * @property $Reclamo_Aseguradora
 * @property $no_reporte
 * @property $Asegurado
 * @property $Poliza_Anexo
 * @property $Inicio_Poliza
 * @property $Fin_Poliza
 * @property $Fecha_Siniestro
 * @property $Fecha_Asignación
 * @property $Fecha_Reporte
 * @property $Lugar_Siniestro
 * @property $Sector_Evento
 * @property $Hora_Siniestro
 * @property $Seguro_Afectado
 * @property $Circunstancias
 * @property $Causa
 * @property $Observaciones
 * @property $Nombre
 * @property $CI
 * @property $Parentezo
 * @property $Ocupacion
 * @property $Telefonos
 * @property $Cobertura
 * @property $Compañía_de_Seguros
 * @property $Ejercicio
 * @property $Ejecutivo
 * @property $Valor_de_la_Reserva
 * @property $Requerimientos
 * @property $Subrogación
 * @property $Salvamento
 * @property $Estado
 * @property $Ejecutivo2
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Caso extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_cfr',
        'aseguradora',
        'ramo',
        'broker',
        'reclamo_aseguradora',
        'no_reporte',
        'asegurado',
        'poliza_anexo',
        'inicio_poliza',
        'fin_poliza',
        'fecha_siniestro',
        'fecha_asignacion',
        'fecha_reporte',
        'lugar_siniestro',
        'sector_evento',
        'hora_siniestro',
        'seguro_afectado',
        'circunstancias',
        'causa',
        'observaciones',
        'nombre',
        'ci',
        'parentezo',
        'ocupacion',
        'telefonos',
        'cobertura',
        'compania_de_seguros',
        'inspector',
        'ejecutivo',
        'valor_de_la_reserva',
        'requerimientos',
        'subrogacion',
        'salvamento',
        'estado',
        'ejecutivo2',
        'informe_final',
        'facturacion',
        'nombre_asegurado',
        'direccion_asegurado',
        'email_asegurado',
        'id_provincia',
        'robo_fractura',
        'robo_violencia' ,
        'robo_escalamiento' ,
        'robo_otros_detalle'   ,
        'robo_alarma' ,
        'robo_guardiania',
        'robo_camaras',
        'robo_sensores' ,
        'robo_rejas_externas' ,
        'robo_candados',
        'robo_polic ia'

    ];
    

  
    public function bienes()
    {
        return $this->hasMany(Biene::class, 'id_Caso');
    }
  
}

