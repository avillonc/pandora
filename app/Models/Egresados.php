<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Egresados extends Model
{
    use HasFactory;
 
    public static function rptEgresadosMinisterio($request){
       /* $page = $request['page'];
        $itemsPerPage = $request['itemsPerPage'];
        $init = ($page - 1) * $itemsPerPage;
        */
        /** Parametros */ 
        $cod_term = $request['cod_term'];
        $ccarr = $request['ccarr'];
        $nivel_code = $request['nivel_code'];
        $anio_egreso = $request['anio_egreso']; 
        $doc_identidad = $request['doc_identidad']; 
        $last_name = $request['last_name'];
        $anio_actualiza = $request['anio_actualiza'];
        $id_situ = $request['id_situ'];
        $origen = $request['id_origen'];

        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISMA_EGRESADOS_MINISTERIO_REPORTE(:cod_term,:ccarr,:nivel_code,:anio_egreso, 
                                                                               :doc_identidad,:last_name,:anio_actualiza,
                                                                               :id_situ, :origen, :cursor); END;");
        $stmt->bindParam(':cod_term',$cod_term, \PDO::PARAM_STR);
        $stmt->bindParam(':ccarr', $ccarr, \PDO::PARAM_STR);
        $stmt->bindParam(':nivel_code', $nivel_code, \PDO::PARAM_STR);
        $stmt->bindParam(':anio_egreso', $anio_egreso, \PDO::PARAM_STR); 
        $stmt->bindParam(':doc_identidad', $doc_identidad, \PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, \PDO::PARAM_STR); 
        $stmt->bindParam(':anio_actualiza', $anio_actualiza, \PDO::PARAM_STR); 
        $stmt->bindParam(':id_situ', $id_situ, \PDO::PARAM_STR);  
        $stmt->bindParam(':origen', $origen, \PDO::PARAM_STR);   
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT); 
        $stmt->execute();
        oci_execute($cursor);

        $result = oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW); 
       // oci_set_prefetch($cursor, $init + $itemsPerPage);
       // oci_fetch_all($cursor, $data, $init, $itemsPerPage, OCI_FETCHSTATEMENT_BY_ROW);
   
        $data = array_map('array_change_key_case', $data); 

        $cantidadRegistros = count($data);
        return [
            "data" => $data, "rows" => $cantidadRegistros
        ];    
   }
 
   public static function getCarreraAllByNivel($request)
   {  
       
       $query = "select distinct ccarrera id, stvmajr_desc name
       from isil.tab_mallas_carreras
       inner join STVMAJR on STVMAJR_CODE=ccarrera
       where cperiodo=(select max(cperiodo)
                       from isil.tab_mallas_carreras) " ;
       if(!empty($request['nivel_code'])) {
           $query.= " and substr(ccarrera,1,1) = '".$request['nivel_code']."' "; 
       }  
       return DB::connection('oracle')->select($query);

    }

    public static function getTermcode($request)
    {

        $query = "select 1 orden,cperiodo id,cperiodo||' '||dperiodo name
                    from ISIL.TAB_PERIODOS_NIVEL
                    where cnivel='".$request['nivel_code']."'  and
                        cestad='S'
                  UNION
                 select 2 orden,cperiodo id,cperiodo||' '||dperiodo name
                    from ISIL.TAB_PERIODOS_NIVEL
                    where cnivel='".$request['nivel_code']."'  and
                            cestad='A'
                    order by 1 ,2 desc";

        //dd($query);
        return DB::connection('oracle')->select($query);

       }
    public static function getMaestras($request)
       { 
           
          $idTabla = $request['idTabla'];
          /** */
          $pdo = DB::connection('oracle')->getPdo();
          $stmt = $pdo->prepare("BEGIN ISIL.SP_ISMA_MAESTRAS_LISTAR_X_TABLA(:idTabla,:cursor); END;");
          $stmt->bindParam(':idTabla',$idTabla, \PDO::PARAM_STR);
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
