<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Caso; 
use App\Models\Aseguradora;
use App\Models\Ramo;
use App\Models\Broker;
use App\Models\Causa;
use App\Models\Seguro;
use App\Models\User;
use App\Models\Biene;
use App\Models\Asegurado; // Importar el modelo Asegurado
 
/**
 * Class CasoController
 * @package App\Http\Controllers
 */
class CasoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index()
     {
         // Usando DB::table para obtener resultados paginados ordenados por Fecha_Siniestro
         $casos = DB::table('bandeja')
         ->select('*') // o explícitamente 'id', 'fecha_siniestro', 'no_reporte', etc.
         ->orderBy('fecha_siniestro', 'desc')
         ->paginate(50);
         
         return view('caso.index', compact('casos'))
                ->with('i', (request()->input('page', 1) - 1) * $casos->perPage());
     }

  
 
 
     
     public function apiRecibir(Request $request)
     {
         // Validar datos
         $validator = Validator::make($request->all(), [
             'observaciones' => 'nullable|string',
             'caseData' => 'nullable|string',
             'bienes' => 'nullable|string',
             'imagenes'   => 'nullable|array',
             'imagenes.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
             'firmas'     => 'nullable|array',
             'firmas.*'   => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
         ]);
     
         if ($validator->fails()) {
             return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
         }
     
         // Log de datos recibidos
         \Log::info('📥 Datos recibidos en apiRecibir', [
             'timestamp' => now()->toDateTimeString(),
             'original_files' => $request->file('imagenes') ? collect($request->file('imagenes'))->map->getClientOriginalName() : null,
             'firmas' => $request->file('firmas') ? collect($request->file('firmas'))->map->getClientOriginalName() : null,
             'observaciones' => $request->input('observaciones'),
             'caseData' => $request->input('caseData'),
             'bienes' => $request->input('bienes'),
             'IP' => $request->ip(),
             'User-Agent' => $request->userAgent(),
         ]);
     
         // Decodificar datos
         $observaciones = json_decode($request->input('observaciones'), true);
         $caseData = json_decode($request->input('caseData'), true);
         $bienes = json_decode($request->input('bienes'), true);
     
        //  // Guardar imágenes
        //  if ($request->hasFile('imagenes')) {
        //      foreach ($request->file('imagenes') as $file) {
        //          $originalName = $file->getClientOriginalName();
        //          preg_match('/bien_(\d{1,10})_/', $originalName, $matches);
        //          $id_bien = isset($matches[1]) ? intval($matches[1]) : null;
     
        //          if ($id_bien && $id_bien <= 2147483647) {
        //              $file->storeAs('public/imagenes', $originalName);
        //              DB::update("EXEC sp_ActualizarImagen ?, ?", [$id_bien, $originalName]);
        //          } else {
        //              Log::warning("❌ id_bien inválido o demasiado largo: $originalName");
        //          }
        //      }
        //  }
     
         // Guardar firmas
         $firmasGuardadas = [];
         if ($request->hasFile('firmas')) {
             foreach ($request->file('firmas') as $firma) {
                 $filename = time() . '_' . $firma->getClientOriginalName();
                 $path = $firma->storeAs('public/firmas', $filename);
                 $firmasGuardadas[] = Storage::url($path);
             }
         }
     
         // Guardar caso (ejemplo con modelo)
         if ($caseData) {
             \App\Models\Caso::updateOrCreate(
                 ['id' => $caseData['id']],
                 [
  
                     'nombre_asegurado' => $caseData['Nombre_Asegurado'],
                     'direccion_asegurado' => $caseData['Direccion_Asegurado'],
                     'email_asegurado' => $caseData['Email_Asegurado'],
                     'fecha_siniestro' => $caseData['Fecha_Siniestro'],
                     'hora_siniestro' => $caseData['Hora_Siniestro'],
                     'lugar_siniestro' => $caseData['Lugar_Siniestro'],
                     'circunstancias' => $caseData['Circunstancias'], 
                     'observaciones' => $caseData['Observaciones'],
                     'estado' => $caseData['Estado'],
                 ]
             );
         }
     
         // Guardar bienes
         if ($bienes) {
             foreach ($bienes as $bien) {
                 \App\Models\Bien::updateOrCreate(
                     ['id_bien' => $bien['id_bien']],
                     [
                         'id_Caso' => $bien['id_Caso'],
                         'bien_asegurado' => $bien['Bien_Asegurado'],
                         'objeto' => $bien['Objeto'],
                         'tipo' => $bien['Tipo'],
                         'caracteristicas' => $bien['Caracteristicas'],
                         'detalles' => $bien['Detalles'],
                     ]
                 );
             }
         }
     

     
         return response()->json([
             'success' => true,
             'message' => 'Datos recibidos y almacenados correctamente'
         ], 200);
     }
     
 

    public function apiCasos()
    {
        // Ejecuta el query utilizando el constructor de consultas
        $casos = DB::table('casos as a')
            ->join('ramos as b', 'a.ramo', '=', 'b.id') 
            ->join('aseguradoras as d', 'a.aseguradora', '=', 'd.id')
            ->select('a.id', 'b.ramo', 'a.nombre_asegurado', 'd.aseguradora')
            ->get();
        return response()->json($casos);
    }

    public function apiCasosDetalle($id)
    {
        $caso = Caso::find($id);
        return response()->json($caso);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Crea una nueva instancia de Caso
        $caso = new Caso();
 
        // Obtiene las opciones de los modelos relacionados usando pluck
        $Aseguradora = Aseguradora::pluck('aseguradora', 'id');
        $Ramo = Ramo::pluck('ramo', 'id');
        $Broker = Broker::pluck('broker', 'id');
        $Causa = Causa::pluck('causa', 'id');
        $Seguro = Seguro::pluck('seguro', 'id');
        $User = User::pluck('name', 'id'); 
        $bienes = Biene::paginate();
    
        // Pasa las variables a la vista
        return view('caso.create', compact('caso', 'Aseguradora', 'Ramo', 'Broker', 'Causa', 'Seguro', 'User', 'bienes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        $caso = Caso::create($request->all());

        return redirect()->route('casos.index')
            ->with('success', 'Caso created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $caso = Caso::find($id);

        return view('caso.show', compact('caso'));
    }

    public function showForm()
    {
         
        return view('caso.form', compact( ));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $caso = Caso::find($id);
        $Aseguradora = Aseguradora::pluck('aseguradora','id');
        $Ramo = Ramo::pluck('ramo','id');
        $Broker = Broker::pluck('broker','id');
        $Causa = Causa::pluck('causa','id');
        $Seguro = Seguro::pluck('seguro','id');
        $User = User::pluck('name','id');  
        $bienes = Biene::paginate();
        
        return view('caso.edit', compact('caso','Aseguradora', 'Ramo','Broker','Causa','Seguro','User','bienes' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Caso $caso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Caso $caso)
    {
     

        $caso->update($request->all());

        return redirect()->route('casos.index')
            ->with('success', 'Caso updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $caso = Caso::find($id)->delete();

        return redirect()->route('casos.index')
            ->with('success', 'Caso deleted successfully');
    }

    
    public function getAseguradoras(Request $request)
    {
        $aseguradoras = DB::table('aseguradoras')
            ->where('id_ramo', $request->ramo_id)
            ->select('aseguradora', 'id')
            ->get();
    
        $casuas = DB::table('causas')
            ->where('id_ramo', $request->ramo_id)
            ->select('causa', 'id')
            ->get();
    
        return response()->json([
            'aseguradoras' => $aseguradoras,
            'casuas' => $casuas
        ]);
    }
    

}
