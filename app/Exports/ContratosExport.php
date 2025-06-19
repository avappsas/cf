<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;

class ContratosExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $f = $this->filters;

        $q = DB::table('Historico_Contratos')
            ->select(
                'Cant', 
                'Estado',
                'N_C',
                'Num_Contrato',
                'Tipo_Doc',
                'Documento',
                'Nombre',
                'Celular',
                'Nivel',
                'Fecha_inicio',
                'Fecha_Fin',
                'Plazo',
                'Fecha_Suscripcion',
                'Cuotas',
                'Valor_Total', 
                'Valor_Mensual',   
                'RPC',
                'Fecha_Invitacion',  
                'Nombre_Oficina',   
                'CEDULA',
                'Nombre_Interv',
                'CARGO', 
                'CORREO',
                'Celular_Supervisor',
                'Mes_Inicio_Contrato', 
                'Objeto',
                'Actividades'
            );

        if (!empty($f['query'])) {
            $q->where(function($sub) use ($f) {
                $sub->where('Nombre', 'like', "%{$f['query']}%")
                    ->orWhere('Documento', 'like', "%{$f['query']}%");
            });
        }

        if (!empty($f['estado'])) {
            $q->where('Estado', $f['estado']);
        }

        if (!empty($f['anio'])) {
            $q->whereYear('Fecha_Inicio', $f['anio']);
        }

        if (!empty($f['mes'])) {
            $q->whereMonth('Fecha_Inicio', $f['mes']);
        }

        return $q->orderBy('N_C', 'desc');
    }

    public function headings(): array
    {
        return [
            'Cant', 
            'Estado',
            'N_C',
            'Num_Contrato',
            'Tipo_Doc',
            'Documento',
            'Nombre',
            'Celular',
            'Nivel',
            'Fecha_inicio',
            'Fecha_Fin',
            'Plazo',
            'Fecha_Suscripcion',
            'Cuotas',
            'Valor_Total', 
            'Valor_Mensual',   
            'RPC',
            'Fecha_Invitacion', 
            'Nombre_Oficina',   
            'CC_Interventor',
            'Nombre_Interv',
            'CARGO', 
            'CORREO',
            'Celular_Supervisor',
            'Mes_Inicio_Contrato', 
            'Objeto',
            'Actividades'
        ];
    }
}
