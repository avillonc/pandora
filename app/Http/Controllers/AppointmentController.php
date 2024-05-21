<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Http\Response;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response as Download;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Exception;
use SplFileInfo;

class AppointmentController extends Controller
{
    public function listProgramacionPsicologia(Request $request)
    { 
    try {  
        $data = Appointment::listProgramacionPsicologia($request); 
        return response($data, Response::HTTP_OK); 
    } catch (\Throwable $th) { 
    }
    }

    public function listCantSesiones(Request $request)
    { 
        $pidm = $request->session()->get('pidm');
    try {  
        $value['pidm'] = $pidm; 
        $data = Appointment::listCantSesiones($value); 
        return response($data, Response::HTTP_OK); 
    } catch (\Throwable $th) {
        //throw $th;
    }
    }
    public function listAtencionesPaciente(Request $request)
    { 
    try {  
        $data = Appointment::listAtencionesPaciente($request); 
        return response($data, Response::HTTP_OK); 
    } catch (\Throwable $th) {
        //throw $th;
    }
    }

    public function getFicha(Request $request)
    { 
        
        $user = Auth::user(); 
        $pidm = $request->session()->get('pidm');
    try {  
        $value['pidm'] = $pidm; 
        $data = Appointment::getFicha($value); 
        return response($data, Response::HTTP_OK); 
    } catch (\Throwable $th) {
        //throw $th;
    }
    }

   public function getCitas(Request $request)
    { 
        
        $user = Auth::user(); 
        $pidm = $request->session()->get('pidm');
    try {  
        $value['pidm'] = $pidm; 
        $data = Appointment::getCitas($value); 
        return response($data, Response::HTTP_OK); 
    } catch (\Throwable $th) {
        //throw $th;
    }
    }
    
    public function getDocumentos(Request $request)
    { 
        
        $user = Auth::user(); 
        $pidm = $request->session()->get('pidm');
    try {  
        $value['pidm'] = $pidm; 
        $data = Appointment::getDocumentos($value); 
        return response($data, Response::HTTP_OK); 
    } catch (\Throwable $th) {
        //throw $th;
    }
    }
    
    public function getInformes(Request $request)
    { 
        
        $user = Auth::user(); 
        $pidm = $request->session()->get('pidm');
    try {  
        $value['pidm'] = $pidm; 
        $data = Appointment::getInformes($value); 
        return response($data, Response::HTTP_OK); 
    } catch (\Throwable $th) {
        //throw $th;
    }
    }
    public function listarCalendario(Request $request)
    {
        $user = Auth::user(); 
    try { 
        $value['dni'] = $user->dni; 
        $data = Appointment::listarCalendario($value);
      
        return response($data, Response::HTTP_OK); 
    } catch (\Throwable $th) {
        //throw $th;
    }
    }
    public function buscarAlumnoxDni(Request $request)
    { 
    try {  
        $user = Auth::user(); 
        $value['dni'] = $user->dni; 
        $data = Appointment::buscarAlumnoxDni($value);
      
        return response($data, Response::HTTP_OK); 
    } catch (\Throwable $th) {
        //throw $th;
    }
      
    }
    public function getPaciente(Request $request)
    { 
    try {  
        $user = Auth::user(); 
        $value['dni'] = $user->dni; 
        $data = Appointment::getPaciente($value);
      
        return response($data, Response::HTTP_OK); 
    } catch (\Throwable $th) {
        //throw $th;
    }
      
    }
    public function getCuposDisponibles(Request $request)
    {
        $user = Auth::user(); 
    try {  
        $data = Appointment::getCuposDisponibles($request);
      
        return response($data, Response::HTTP_OK); 
    } catch (\Throwable $th) {
        //throw $th;
    }
      
    }

    public function listPsicologos(Request $request)
    {
        $user = Auth::user(); 
    try {  
        $data = Appointment::listPsicologos($request);
      
        return response($data, Response::HTTP_OK); 
    } catch (\Throwable $th) {
        //throw $th;
    }
      
    }

    public function citaPacienteDetalle(Request $request)
    { 
    try {  
        $data = Appointment::citaPacienteDetalle($request); 
        return response($data, Response::HTTP_OK); 
    } catch (\Throwable $th) {
        //throw $th;
    }
    }
    public function registrarHorario(Request $request)
    { 
        $user = Auth::user();
         
        try {  
            $dias = $request->dias;   
            //dd($request->dias);
            foreach ($dias as $dia) {   
                    $nroDia = $dia;  
                    $value = [ 
                        'sede' => $request['sede'],
                        'tipo_cita' => $request['tipo_cita'],
                        'cantidad' => $request['cantidad'],
                        'duracion' => $request['duracion'],
                        'fecha_desde' => $request['fecha_desde'],
                        'fecha_hasta'=> $request['fecha_hasta'],
                        'hora_ini' => $request['hora_ini'],
                        'hora_fin'=> $request['hora_fin'],
                        'nro_dia'=> $nroDia,
                        'code_evento' => $request['code_evento'],
                        'code_modulo' => $request['code_modulo'],
                        'pidm' => $request['pidm'],
                        'user'=> $user->username,
                    ]; 
                   Appointment::registrarHorario($value);   
            }

        //dd($user->last_name); 
            return response([], Response::HTTP_OK); 

        } catch (Exception $e) {
            return $this->sendError('Error en registro de horario');
        }
    }

    public function registrarCita(Request $request)
    { 
        $user = Auth::user(); 
        $pidm = $request->session()->get('pidm');
        try {   
           // dd($request);
                $value['id_item'] = $request['id'];
                $value['pidm'] = $pidm; 
                $value['user'] = $user->dni;; 
                Appointment::registrarCita($value);   
            return response([], Response::HTTP_OK); 

        } catch (Exception $e) {
            return $this->sendError('Error al registra la cita');
        }
    }  

    public function registrarFicha(Request $request)
    { 
        try {    
                Appointment::registrarFicha($request);   
            return response([], Response::HTTP_OK); 

        } catch (Exception $e) {
            return $this->sendError('Error al registra la ficha');
        }
    }
    
    public function cancelarCita(Request $request)
    { 
        try {    
                Appointment::cancelarCita($request);   
            return response([], Response::HTTP_OK); 

        } catch (Exception $e) {
            return $this->sendError('Error al cancelar cita');
        }
    } 
    
    public function eliminarDocumento(Request $request)
    { 
        try {    
                Appointment::eliminarDocumento($request);   
            return response([], Response::HTTP_OK); 

        } catch (Exception $e) {
            return $this->sendError('Error al eliminar documento');
        }
    } 

    public function grabarDocumentos(Request $request)
    {
        $user = Auth::user();
        $pidm = $request->session()->get('pidm');
        $filesUploaded = [];  
        if ($request->has('inputfile')) {
            foreach ($request->inputfile as $key => $files) {
                foreach ($files as $index => $file) { 
                    $tipo_docu = $request->input("tipo_docu.{$key}.{$index}", 'default');
            
                    if (is_null($file) || !$file->isValid()) {
                        return response()->json(['error' => 'Documento adjunto inválido.'], 400);
                    }

                    $orig_name = str_replace(" ", "", $file->getClientOriginalName());
                    $fileType = $file->getClientMimeType(); 
                    $name = $file->getClientOriginalName();
                    $filename = uniqid() . $name;
    
                    $file->storeAs('Psicologia/' . $user->dni . '/documentos'. '/' , $filename, 's3');
                    $url = Storage::disk('s3')->url($filename);
                    if (Storage::disk('s3')->exists($filename)) {
                        $file['url'] = $url;
                        // Guardar los detalles del archivo y su tipo en la base de datos
                        $value = [
                            'pidm' => $pidm,
                            'url' => $url,
                            'tipo_docu' => $tipo_docu,
                            'nombre_archivo' => $filename,
                            'user' => $user->dni
                        ];
                        Appointment::grabarDocumentos($value);
                    } else {
                        $fileContent = $file->get();
                        Storage::disk('s3')->put('Psicologia/' .$user->dni . '/documentos'. '/' . $filename, $fileContent);
                        $url = Storage::disk('s3')->url('Psicologia/' .$user->dni . '/documentos'. '/'  . $filename);
                        
                        $value = [
                            'pidm' => $pidm,
                            'url' => $url,
                            'tipo_docu' => $tipo_docu,
                            'nombre_archivo' => $filename,
                            'user' => $user->dni
                        ];
                        Appointment::grabarDocumentos($value);
                    }  
                    
                    $filesUploaded[] = ['filename' => $filename, 'url' => $url, 'tipo_docu' => $tipo_docu];
            
            
                }
            }
        } 
        return response()->json([
            'title' => 'Actualización exitosa',
            'status' => 'success',
            'message' => 'Se actualizó satisfactoriamente',
            'files_uploaded' => $filesUploaded
        ]);
    }

    public function grabarDocumentos_(Request $request)
    {
        $user = Auth::user(); 
        $pidm = $request->session()->get('pidm'); 
        $file = null;
        $tipo_docu = null;
        $filesUploaded = []; 
        if ($request->hasfile('inputfile')) { 
            foreach ($request->file('inputfile') as $key => $file) {
                if (is_null($file) || !$file->isValid()) {
                    return $this->sendError('Documento Adjunto Invalido.');
                }
                $tipo_docu = $request->input("tipo_docu.{$key}.{$index}");
                $orig_name = str_replace(" ", "", $file->getClientOriginalName());
                $fileType = $file->getClientMimeType(); 
                $name = $file->getClientOriginalName(); 
                $filename = uniqid() . $name;
    
                $file->storeAs('Psicologia/' .$user->dni. '/documentos'. '/'  , $filename, 's3');
                 
                $url = Storage::disk('s3')->url($filename);
    
                if (Storage::disk('s3')->exists($filename)) {
                 
                    // El archivo existe en S3, realiza acciones adicionales si es necesario
                    $file['url'] = $url;
                    $file['documento'] = $user->dni;
                   
                    $value = [
                        'pidm' => $pidm,
                        'url' => $url,
                        'tipo_docu' => $tipo_docu,
                        'nombre_archivo' => $filename,
                        'user' => $user->dni
                    ];
                    Appointment::grabarDocumentos($value);  
                    
                } else {
                    $fileContent = $file->get(); // Obtener el contenido del archivo

                    Storage::disk('s3')->put('Psicologia/' . $user->dni . '/documentos'. '/'  . $filename, $fileContent);
                    $url = Storage::disk('s3')->url('Psicologia/' .$user->dni  . '/documentos'. '/'  . $filename);
                  
                    $value = [
                        'pidm' => $pidm,
                        'url' => $url,
                        'tipo_docu' => $tipo_docu,
                        'nombre_archivo' => $filename,
                        'user' => $user->dni
                    ];
                    Appointment::grabarDocumentos($value);   
                }

                $filesUploaded[] = [
                    'filename' => $filename,
                    'url' => $url,
                    'documento' =>$user->dni,
                ];
            }

        }
       
        $arreglo_enviar = [
            'title' => 'Actualización exitosa',
            'status' => 'success',
            'message' => 'Se actualizó satisfactoriamente',
            'files_uploaded' => $filesUploaded, 
            'fec_creacion' => now(),
        ];
    
        return response()->json($arreglo_enviar);
    }
 
    public function viewDocument($file)
    {
        $user = Auth::user(); 
        $info = new SplFileInfo($file); 
        $carpeta = 'Psicologia/'. $user->dni .'/documentos'. '/' .$file;
        $ext = $info->getExtension();
        $s3FilePath = $carpeta;
 
        $headers = [
            'Content-Type'        => 'Content-Type: application/'.$info->getExtension(),
            'Content-Disposition' => 'attachment; filename="'. $file .'"',
        ];
        
        return Download::make(Storage::disk('s3')->get($s3FilePath), Response::HTTP_OK, $headers);
     
    }
    
    public function registrarInforme(Request $request)
    { 
        try {    
                Appointment::registrarInforme($request);   
            return response([], Response::HTTP_OK); 

        } catch (Exception $e) {
            return $this->sendError('Error al registra la ficha');
        }
    }
    public function actualizarDatos(Request $request)
    { 
        try {    
                Appointment::actualizarDatos($request);   
            return response([], Response::HTTP_OK); 

        } catch (Exception $e) {
            return $this->sendError('Error al registra la ficha');
        }
    }
}
