<?php

namespace App\Exports;

use App\User;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class exportLote implements FromCollection,WithHeadings, WithDrawings, WithCustomStartCell
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Nombre',
            'Documento',
            'RPC',
            'Num_Contrato',
            'fondo',
            'Cuota',
        ];
    }

    public function drawings()
    {
        // Agrega la imagen a la celda B2 del Excel
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(public_path('/images/logo_CuentaFacil/png/color_with_backgroundx.png'));
        $drawing->setHeight(50);
        $drawing->setCoordinates('A1');

        return [$drawing];
    }

    public function collection()
    {
        $idLider = auth()->user()->usuario;
        //  $afiliados = DB::table('Afiliados')->where('lider', $idLider)->select('id','Cedula','Primer_Nombre', 'Segundo_Nombre', 'Primer_Apellido', 'Segundo_Apellido', 'celular', 'Telefono', 'Direccion')->get();
         $data = DB::select("select d.Nombre,d.Documento,b.RPC,b.Num_Contrato,0 as fondo,a.Cuota
         from cuotas a
         left join Contratos b
         on a.Contrato = b.Id
         inner join Base_Datos d
         on b.No_Documento = d.Documento
         order by d.Documento,a.Cuota;");

        //  print_r($data);die();

         // Retorna la colección de afiliados
         return collect($data);

    }

    public function startCell(): string
    {
        return 'A4';
    }
}