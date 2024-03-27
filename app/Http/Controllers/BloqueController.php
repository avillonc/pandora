<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Programs;
use App\Models\Variables;
use App\Models\PaymentMethods;

class BloqueController extends Controller
{
    public function getDatosAlumno()
    { 
        $user = Auth::user();

        $dni = $user->dni;
        //dd($dni);
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISILNET_GET_ALUMNO_BUSCAR_X_DNI(:dni,:cursor); END;");
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

    public function getBloquesDisponibles(Request $request)
    { 
        $curso = $request['curso'];
        $perio = $request['perio'];
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISILNET_GET_BLOQUES_DISPONIBLES(:perio,:curso,:cursor); END;");
        $stmt->bindParam(':perio',$perio, \PDO::PARAM_STR);
        $stmt->bindParam(':curso',$curso, \PDO::PARAM_STR);
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
     
        $stmt->execute(); 
        oci_execute($cursor);
        $result = oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $data = array_map('array_change_key_case', $data); 
        return [
            "data" => $data
        ]; 
    }
}
