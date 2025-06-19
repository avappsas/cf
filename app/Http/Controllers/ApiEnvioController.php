<?php

namespace App\Http\Controllers;

use App\Models\Caso;
use Illuminate\Http\Request;
use App\Models\Aseguradora;
use App\Models\Ramo;
use App\Models\Broker;
use App\Models\Causa;
use App\Models\Seguro;
use App\Models\User;
use App\Models\Biene;
use App\Models\Asegurado; // Importar el modelo Asegurado
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;  
/**
 * Class CasoController
 * @package App\Http\Controllers
 */
class ApiEnvioController extends Controller
{
    public function apiDetalleCaso($id_caso)
    {
        // Ejecuta el query utilizando el constructor de consultas
        $casos = DB::select("SELECT dbo.Detalle_Caso($id_caso)") ;
               
        return $casos[0];
    }


    public function apiobjeto($id_caso)
    {
        // Obtener el ramo desde la tabla casos
        $ramo = DB::table('casos')
                  ->where('id', $id_caso)
                  ->value('ramo'); // Suponiendo que 'ramo' es el campo que corresponde con 'id_ramo'
    
        if (!$ramo) {
            return response()->json(['error' => 'Caso no encontrado o sin ramo'], 404);
        }
    
        // Buscar los objetos que coinciden con ese ramo
        $objetos = DB::table('objetos')
                     ->where('id_ramo', $ramo)
                     ->get();
    
        return response()->json($objetos);
    }

    public function apiobjetotipo($id_objeto)
    {
        // Ejecuta el query utilizando el constructor de consultas
        $tipos = DB::table("tipo_bienes")
                     ->where('id_bien', $id_objeto)
                     ->get();  
        return $tipos;
    }

    public function apicampostipobien($id_tipo_bien)
    {
        // Ejecuta el query utilizando el constructor de consultas
        $campos = DB::table("tipo_bien_campos")
                     ->where('id_tipo_bien', $id_tipo_bien)
                     ->get();  
        return $campos;
    }



}