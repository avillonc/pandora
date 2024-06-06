<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Data extends Model
{
    use HasFactory;

  
    public function getCarreraAll()
    {
   
           $query = "select SRBRICC_MAJR_CODE id, SRBRICC_ACAD_PROG_NAME name, SRBRICC_LEVL_CODE as levl_code
                     from SRBRICC";
    
           return DB::connection('oracle')->select($query);
   
    }
 

    public static function getMaestras($request)
    { 
            $idTabla = $request['idTabla'];
            $idAsoci = $request['idAsoci'];
            $idRegis = $request['idRegis'];
            /** */
            $pdo = DB::connection('oracle')->getPdo();
            $stmt = $pdo->prepare("BEGIN ISIL.SP_ISMA_MAESTRAS_LISTAR_X_TABLA_ASOCIADO(:idTabla, :idRegis, :idAsoci, :cursor); END;");
            $stmt->bindParam(':idTabla',$idTabla, \PDO::PARAM_STR);
            $stmt->bindParam(':idRegis',$idRegis, \PDO::PARAM_STR);
            $stmt->bindParam(':idAsoci',$idAsoci, \PDO::PARAM_STR);
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
