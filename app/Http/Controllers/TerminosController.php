<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Programs;
use App\Models\Variables;
use App\Models\PaymentMethods;

class TerminosController extends Controller
{

    public function validateTerminos (Request $request)
    {
        $user = Auth::user();
        $periodo  = $request->periodo;     
        $dni = $user->dni;
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISILNET_GET_TERMINOS(:dni, :periodo, :cursor); END;");
        
        $stmt->bindParam(':dni', $dni, \PDO::PARAM_STR);
        $stmt->bindParam(':periodo', $periodo, \PDO::PARAM_STR);
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
     
        $stmt->execute(); 
        oci_execute($cursor);
    
        $data = [];
        // Recoge todas las filas en un array
        oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
    
        return [
            "data" => $data,
        ]; 
    }
    public function saveTerminos(Request $request)
    { 
        $user = Auth::user();
        $periodo  = $request->periodo;     
        $radio  = $request->radio?1:0;     
        $dni = $user->dni;
        $ip = $request->ip();
       
        try {
            DB::connection('oracle')->select('CALL isil.SP_ISILNET_TERMINOS(?, ?, ?, ?, ?)', [
                $dni,
                $periodo,
                $ip,
                $radio,
                &$status,
             
            ]);
           
            return [
                "data" => 'ok'
                
            ]; 

        } catch (\Exception $e) {
            //dd($e->getMessage());
        }

        $data = [];
 
        return [
            "data" => $data,
            'total' => array_sum(array_column($data,'SFRRGFE_PER_CRED_CHARGE'))
        ]; 
    }
    
    
}
