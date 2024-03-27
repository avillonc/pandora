<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Programs;
use App\Models\Variables;
use App\Models\PaymentMethods;
class TarifarioController extends Controller
{

    public function getDatosTarifario(Request $request)
    { 
        $user = Auth::user();
        $periodo  = $request->periodo;
        $cantidad = $request->cantidad;
     
        $dni = $user->dni;

        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISILNET_TARIFARIO(:dni, :cantidad, :periodo, :cursor); END;");
        
        $stmt->bindParam(':dni', $dni, \PDO::PARAM_STR);
        $stmt->bindParam(':cantidad', $cantidad, \PDO::PARAM_STR);
        $stmt->bindParam(':periodo', $periodo, \PDO::PARAM_STR);
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
     
        $stmt->execute(); 
        oci_execute($cursor);
    
        $data = [];
    
        // Recoge todas las filas en un array
        oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        return [
            "data" => $data,
            'total' => array_sum(array_column($data,'SFRRGFE_PER_CRED_CHARGE'))
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
