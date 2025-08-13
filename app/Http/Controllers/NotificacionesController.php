<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use App\Notifications\EstadoNotificacion;
use App\Models\NotificacionLog;
use App\Notifications\Destinatarios\InternoNotificable;
use App\Notifications\Destinatarios\UsuarioNotificable;

class NotificacionesController extends Controller
{

    public function notificarInterno(Request $request)
    {
        $idContrato = $request->input('idContrato');
        $idCuota = $request->input('idCuota');
        $estado = (object) $request->input('estadoActual');

        if (empty($estado->EstadoInterno)) {
            Log::warning("⚠️ EstadoInterno vacío en notificarInterno para contrato $idContrato");
            return response('Estado interno no válido', 400);
        }

        $telefono = null;
        $correo = null;

        if ($estado->notificarInterno == 1) {
            $notificado = DB::table('Contratos as c')
                ->select('i.whatsapp_notificacion', 'i.CORREO')
                ->join('Interventores as i', 'i.Id', '=', 'c.Interventor')
                ->where('c.id', $idContrato)
                ->first();

            if ($notificado) {
                $telefono = $notificado->whatsapp_notificacion ?? $telefono;
                $correo = $notificado->CORREO;
            }
        } else {
            $telefono = $estado->notificarInterno;
        }

        $interno = new InternoNotificable($telefono, $correo);

        // 🧠 Generar mensaje según idCuota
        $mensaje = ($idCuota == 1)
            ? 'El contrato fue actualizado internamente: ' . $estado->EstadoInterno
            : 'La cuenta fue actualizada internamente: ' . $estado->EstadoInterno;

        $interno->notify(new EstadoNotificacion('contrato', [
            'mensaje' => $mensaje,
            'url' => "/contratos/$idContrato"
        ]));

        NotificacionLog::create([
            'tipo' => 'contrato',
            'destinatario' => '',
            'telefono' => $telefono,
            'correo' => $correo,
            'mensaje' => $mensaje,
            'canal' => 'whatsapp',
            'contrato_id' => $idContrato,
        ]);

        return response('Notificación interna enviada ✅', 200);
    }



    public function notificarUsuario(Request $request)
    {
        $idContrato = $request->input('idContrato');
        $idCuota = $request->input('idCuota');
        $documentoContratista = $request->input('documentoContratista');
        $estado = (object) $request->input('estadoActual'); 

        if (empty($estado->EstadoUsuario)) {
            Log::warning("⚠️ EstadoUsuario vacío en notificarUsuario para contrato $idContrato");
            return response('Estado usuario no válido', 400);
        }

        $datosUsuario = DB::table('Base_Datos')
            ->where('Documento', trim($documentoContratista))
            ->first();

        if (!$datosUsuario || !$datosUsuario->Celular) {
            return response('Usuario no encontrado o sin celular', 204);
        }

        $usuario = new UsuarioNotificable(
            $datosUsuario->Celular,
            $datosUsuario->Nombre ?? 'Usuario',
            $datosUsuario->Correo 
        );
 
        // ✅ Generar mensaje según idCuota
        $mensaje = ($idCuota == 1)
            ? 'CONCEJO DE CALI INFORMA: ' . $estado->EstadoUsuario
            : 'CONCEJO DE CALI INFORMA: ' . $estado->EstadoUsuario;

        $usuario->notify(new EstadoNotificacion('contrato', [
            'mensaje' => $mensaje,
            'url' => "/contratos"
        ]));

        NotificacionLog::create([
            'tipo' => 'contrato',
            'destinatario' => $datosUsuario->Nombre ?? 'Usuario',
            'telefono' => $datosUsuario->Celular,
            'correo' => $datosUsuario->Correo,
            'mensaje' => $mensaje,
            'canal' => 'whatsapp' . ($datosUsuario->Correo ? '+mail' : ''),
            'contrato_id' => $idContrato,
        ]);

        return response('Notificación al usuario enviada ✅', 200);
    }

}