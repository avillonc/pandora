<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Programs;
use App\Models\Variables;
use App\Models\PaymentMethods;

class CursosController extends Controller
{
  
    public function getCursos(Request $request)
    { 
        $pidm = $request['pidm'];
        $perio = $request['perio'];
        $ccarr = $request['ccarr'];
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_AVANCE_CURRICULAR(:pidm,:perio,:ccarr,:cursor); END;");
        $stmt->bindParam(':perio',$perio, \PDO::PARAM_STR);
        $stmt->bindParam(':pidm',$pidm, \PDO::PARAM_STR);
        $stmt->bindParam(':ccarr',$ccarr, \PDO::PARAM_STR);
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
