<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Programs;
use App\Models\Variables;
use App\Models\PaymentMethods;
class BolsaLaboralController extends Controller
{

    public function getDatosBolsaLaboral(Request $request)
    { 
      
        $user = Auth::user();
      
        $ip = $request->ip();
        $dni = $user->dni;



        try {
            DB::connection('oracle')->select('CALL isil.SP_ISILNET_BOLSALABORAL(?, ?, ?)', [
                $dni,
                $ip,
                &$status,
             
            ]);
           
            return [
                "data" => 'ok'
                
            ]; 

        } catch (\Exception $e) {
            //dd($e->getMessage());
        }

        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISILNET_GET_BOLSALABORAL(:dni, :ip,  :cursor); END;");
        
        $stmt->bindParam(':dni', $dni, \PDO::PARAM_STR);
        $stmt->bindParam(':ip', $ip, \PDO::PARAM_STR);
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
     
        $stmt->execute(); 
        oci_execute($cursor);
    
        $data = [];
    
        // Recoge todas las filas en un array
        oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        return [
            "data" => $data['0']['VALUE'],
            'token' =>$data['0']['TOKEN'],
        ]; 
    }
    
    

}
