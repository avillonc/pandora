<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
class Appointment extends Model
{
    use HasFactory;

    protected $connection = 'oracle'; 
    protected $table = 'ISIL.TAB_PROG_HORARIA_CB'; 
    protected $primaryKey = 'ID_EVENTO';

    public static function listProgramacionPsicologia($request)
    {
        /** Parametros */ 
       // dd($request);
        $pidm = $request['pidm'];
        $code_modulo = $request['code_modulo'];
        $code_evento = $request['code_evento'];
        $tipo = $request['tipo'];
        $code_sede = $request['code_sede']; 
        /** */
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_PANDORA_PROGRAMACION_CITAS_LIST(:pidm,:code_sede,
                                                                                :code_evento, :code_modulo, :tipo, :cursor); END;");
        $stmt->bindParam(':pidm',$pidm, \PDO::PARAM_STR);
        $stmt->bindParam(':code_sede',$code_sede, \PDO::PARAM_STR);
        $stmt->bindParam(':code_evento',$code_evento, \PDO::PARAM_STR);
        $stmt->bindParam(':code_modulo',$code_modulo, \PDO::PARAM_STR);
        $stmt->bindParam(':tipo',$tipo, \PDO::PARAM_STR); 
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
    
        // Ejecutar la llamada al procedimiento almacenado
        $stmt->execute(); 
        oci_execute($cursor);
        $result = oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $data = array_map('array_change_key_case', $data); 
        $cantidadRegistros = count($data);
        return [
            "data" => $data, "rows" => $cantidadRegistros
        ]; 
    } 

    public static function getCuposDisponibles($request)
    {
        /** Parametros */ 
      // dd($request);
        $id = $request['id'];
        $estado = $request['estado'];
        /** */
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISMA_PROGRAMACION_HOR_ITEM_LIST(:id, :estado,:cursor); END;");
        $stmt->bindParam(':id',$id, \PDO::PARAM_STR);
        $stmt->bindParam(':estado',$estado, \PDO::PARAM_STR);
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
     
        $stmt->execute(); 
        oci_execute($cursor);
        $result = oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $data = array_map('array_change_key_case', $data); 
        $cantidadRegistros = count($data);
        return [
            "data" => $data, "rows" => $cantidadRegistros
        ]; 
    } 

    public static function registrarHorario($request)
    { 
       // dd($request);
        try{ 
            DB::connection('oracle')->select('CALL ISIL.SP_ISMA_PROGHORA_DETALLE_INSERT(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [ 
             $request['fecha_desde'],  
             $request['fecha_hasta'],
             $request['hora_ini'],  
             $request['hora_fin'],
             $request['code_evento'],
             $request['code_modulo'],
             $request['sede'],
             $request['tipo_cita'],
             $request['cantidad'],
             $request['duracion'],
             $request['nro_dia'],
             $request['pidm'] ,
             $request['user']
         ]);

        }catch(\Exception $e){
           return ("No se pudo agregar egresados");
        }
    }

    public static function listPsicologos($request)
    {
        /** Parametros */ 
       // dd($request);
        $evento = $request['pidm'];
        /** */
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISMA_PSICOLOGOS_LISTAR_X_FILTROS(:pidm,:cursor); END;");
        $stmt->bindParam(':pidm',$evento, \PDO::PARAM_STR);
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
    
        // Ejecutar la llamada al procedimiento almacenado
        $stmt->execute(); 
        oci_execute($cursor);
        $result = oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $data = array_map('array_change_key_case', $data); 
        $cantidadRegistros = count($data);
        return [
            "data" => $data, "rows" => $cantidadRegistros
        ]; 
    } 

    public static function buscarAlumnoxDni($request)
    { 
        $dni = $request['dni']; 
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISMA_ALUMNOS_BUSCAR_X_DNI(:dni,:cursor); END;");
        $stmt->bindParam(':dni',$dni, \PDO::PARAM_STR);
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
     
        $stmt->execute(); 
        oci_execute($cursor);
        $result = oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $data = array_map('array_change_key_case', $data); 
        return [
            "data" => $data
        ]; 
    } 
    public static function getPaciente($request)
    { 
        $dni = $request['dni']; 
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_PANDORA_PACIENTE_POR_DOCUM(:dni,:cursor); END;");
        $stmt->bindParam(':dni',$dni, \PDO::PARAM_STR);
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
     
        $stmt->execute(); 
        oci_execute($cursor);
        $result = oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $data = array_map('array_change_key_case', $data); 
        return [
            "data" => $data
        ]; 
    } 
    public static function listarCalendario($request)
    {
        /** Parametros */ 
       // dd($request);
        $dni = $request['dni']; 
        /** */
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISMA_PROGRAMACION_CALENDARIO_X_PIDM(:dni,:cursor); END;");
        $stmt->bindParam(':dni',$dni, \PDO::PARAM_STR); 
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
    
        // Ejecutar la llamada al procedimiento almacenado
        $stmt->execute(); 
        oci_execute($cursor);
        $result = oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $data = array_map('array_change_key_case', $data); 
        $cantidadRegistros = count($data);
        return [
            "data" => $data, "rows" => $cantidadRegistros
        ]; 
    } 
    public  static function listCantSesiones($request)
    { 
        $pidm = $request['pidm']; 
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISMA_SESIONES_X_TIPO_LISTAR(:pidm,:cursor); END;");
        $stmt->bindParam(':pidm',$pidm, \PDO::PARAM_STR);
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT); 
        $stmt->execute(); 
        oci_execute($cursor);
        $result = oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $data = array_map('array_change_key_case', $data); 
        $cantidadRegistros = count($data);
        return [
            "data" => $data, "rows" => $cantidadRegistros
        ]; 
    } 

    public static function listAtencionesPaciente($request)
    { 
        $evento = $request['pidm']; 
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISMA_ATENCIONES_PAC_LISTAR(:pidm,:cursor); END;");
        $stmt->bindParam(':pidm',$evento, \PDO::PARAM_STR);
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
     
        $stmt->execute(); 
        oci_execute($cursor);
        $result = oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $data = array_map('array_change_key_case', $data); 
        $cantidadRegistros = count($data);
        return [
            "data" => $data, "rows" => $cantidadRegistros
        ]; 
    } 

    public static function registrarCita($request)
    { 
        // dd($request);
        try{ 
            DB::connection('oracle')->select('CALL ISIL.SP_ISMA_CITA_INSERT(?, ?, ?)', [ 
             $request['pidm'] ,
             $request['id_item'], 
             $request['user']
         ]);

        }catch(\Exception $e){
           return ("No se pudo agregar egresados");
        }
    }
 
    public static function registrarFicha($request)
    { 
        $user = Auth::user(); 
        $pidm = $request->session()->get('pidm');
        try{ 
            DB::connection('oracle')->select('CALL ISIL.SP_PANDORA_FICHA_CITA_INSERT(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [ 
             $pidm  ,
             $request['code_periodo'], 
             $request['sw_isil'], 
             $request['sw_externo'], 
             $request['psiquiatra'], 
             $request['diagnostico'], 
             $request['code_motivo'], 
             $request['code_tiempo'], 
             $request['observacion'], 
             $request['resumen'], 
             $user->dni
         ]);

        }catch(\Exception $e){
           return ("No se pudo registrar la ficha");
        }
    }

    public static function getFicha($request)
    { 
        $pidm = $request['pidm'];

        
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_PANDORA_FICHA_CITA_LISTAR(:pidm, :cursor); END;");
        $stmt->bindParam(':pidm',$pidm, \PDO::PARAM_STR); 
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
     
        $stmt->execute(); 
        oci_execute($cursor);
        $result = oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $data = array_map('array_change_key_case', $data); 
        $cantidadRegistros = count($data);
        return [
            "data" => $data, "rows" => $cantidadRegistros
        ]; 
    } 
    public static function getCitas($request)
    { 
        $pidm = $request['pidm']; 
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_PANDORA_CITAS_LISTAR(:pidm, :cursor); END;");
        $stmt->bindParam(':pidm',$pidm, \PDO::PARAM_STR); 
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
     
        $stmt->execute(); 
        oci_execute($cursor);
        $result = oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $data = array_map('array_change_key_case', $data); 
        $cantidadRegistros = count($data);
        return [
            "data" => $data, "rows" => $cantidadRegistros
        ]; 
    } 
    public static function cancelarCita($request)
    { 
        $user = Auth::user();  
       // dd($request);
        try{ 
            DB::connection('oracle')->select('CALL ISIL.SP_PANDORA_CITAR_CANCELAR(?, ?, ?, ?, ?)', [ 
             $request['id_sesion'], 
             $request['id_prghor_di'], 
             $request['pidm'], 
             $request['observacion'],  
             $user->dni
         ]);

        }catch(\Exception $e){
           return ("No se pudo cancelar cita");
        }
    } 

    public static function getDocumentos($request)
    { 
        $pidm = $request['pidm'];

        
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_PANDORA_DOCUMENTOS_PACIENTE_LISTAR(:pidm, :cursor); END;");
        $stmt->bindParam(':pidm',$pidm, \PDO::PARAM_STR); 
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
     
        $stmt->execute(); 
        oci_execute($cursor);
        $result = oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $data = array_map('array_change_key_case', $data); 
        $cantidadRegistros = count($data);
        return [
            "data" => $data, "rows" => $cantidadRegistros
        ]; 
    } 

    public static function getInformes($request)
    { 
        $pidm = $request['pidm'];

        
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_PANDORA_INFORMES_PACIENTE_LISTAR(:pidm, :cursor); END;");
        $stmt->bindParam(':pidm',$pidm, \PDO::PARAM_STR); 
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
     
        $stmt->execute(); 
        oci_execute($cursor);
        $result = oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $data = array_map('array_change_key_case', $data); 
        $cantidadRegistros = count($data);
        return [
            "data" => $data, "rows" => $cantidadRegistros
        ]; 
    } 

    public static function grabarDocumentos($request)
    { 
        try{ 
            DB::connection('oracle')->select('CALL ISIL.SP_PANDORA_DOCUMENTOS_CARGAR(?, ?, ?, ?, ?)', [ 
             $request['pidm'],  
             $request['url'],
             $request['tipo_docu'],  
             $request['nombre_archivo'], 
             $request['user']
         ]);

        }catch(\Exception $e){
           return ("No se pudo registrar documentos");
        }
    }
    public static function eliminarDocumento($request)
    { 
        $user = Auth::user(); 
        $pidm = $request->session()->get('pidm'); 

        try{ 
            DB::connection('oracle')->select('CALL ISIL.SP_PANDORA_DOCUMENTOS_DELETE(?, ?)', [ 
             $request['id'],  
             $pidm
         ]);

        }catch(\Exception $e){
           return ("No se pudo registrar documentos");
        }
    }

    public static function registrarInforme($request)
    { 
        $user = Auth::user(); 
        $pidm = $request->session()->get('pidm');
        try{ 
            DB::connection('oracle')->select('CALL ISIL.SP_PANDORA_INFORME_INSERT(?, ?, ?)', [ 
             $pidm  ,
             '1',  
             $user->dni
         ]);

        }catch(\Exception $e){
           return ("No se pudo registrar la ficha");
        }
    }

    public static function actualizarDatos($request)
    { 
        $user = Auth::user(); 
        $pidm = $request->session()->get('pidm');
        try{ 
            DB::connection('oracle')->select('CALL ISIL.SP_PANDORA_DATOS_PACIENTE_ACTUALIZAR(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [ 
             $pidm  , 
             $user->dni,
             $request['genero'],
             $request['estado_civil'],
             $request['fecha_nac'],
             $request['celular'],
             $request['correo'],
             $request['celular_contacto'],
             $request['nombre_contacto'],
             $request['nickname'],
             $request['id_parentesco'],
             $user->dni,
         ]);

        }catch(\Exception $e){
           return ("No se pudo registrar la ficha");
        }
    }

    public static function getCasoEspeciales($request)
    { 
        $user = Auth::user(); 
        $pidm = $request->session()->get('pidm');
        $dni = $user->dni;
        
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_PANDORA_CASOS_ESPECIALES_LISTAR(:dni, :cursor); END;");
        $stmt->bindParam(':dni',$dni, \PDO::PARAM_STR); 
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
     
        $stmt->execute(); 
        oci_execute($cursor);
        $result = oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $data = array_map('array_change_key_case', $data); 
        $cantidadRegistros = count($data);
        return [
            "data" => $data, "rows" => $cantidadRegistros
        ]; 
    } 

    public static function getDiscapacidadPac($request)
    { 
        $pidm = $request['pidm'];
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_PANDORA_PACIENTE_DISCAPACIDAD_LISTAR(:pidm, :cursor); END;");
        $stmt->bindParam(':pidm',$pidm, \PDO::PARAM_STR); 
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
     
        $stmt->execute(); 
        oci_execute($cursor);
        $result = oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $data = array_map('array_change_key_case', $data); 
        $cantidadRegistros = count($data);
        return [
            "data" => $data, "rows" => $cantidadRegistros
        ]; 
    } 

    public static function registrarIncidencia($request)
    { 
        $user = Auth::user();  
        $pidm = $request->session()->get('pidm');
        try{ 
            DB::connection('oracle')->select('CALL ISIL.SP_PANDORA_INCIDENCIAS_INSERT(?, ?, ?, ?, ?, ?)', [ 
             $request['id_incidencia'],
             $request['pidm'],
             $pidm,
             $request['detalle_incidencia'],
             $request['solucion'], 
             $user->dni,
         ]);

        }catch(\Exception $e){
           return ("No se pudo registrar la ficha");
        }
    }

    public static function getIncidencias($request)
    { 
        $pidm = $request['pidm'];
        $pidm_docente = $request->session()->get('pidm');

      //  dd($pidm_docente);

        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_PANDORA_INCIDENCIAS_LISTAR(:pidm,:pidm_docente, :cursor); END;");
        $stmt->bindParam(':pidm',$pidm, \PDO::PARAM_STR); 
        $stmt->bindParam(':pidm_docente',$pidm_docente, \PDO::PARAM_STR); 
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
     
        $stmt->execute(); 
        oci_execute($cursor);
        $result = oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $data = array_map('array_change_key_case', $data); 
        $cantidadRegistros = count($data);
        return [
            "data" => $data, "rows" => $cantidadRegistros
        ]; 
    } 


}
