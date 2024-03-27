<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Programs;
use App\Models\Variables;
use App\Models\PaymentMethods;

class DataController extends Controller
{
    public function getTermcode()
    {
        /*$query = "SELECT cperiodo period_val,cperiodo||' - '||dperiodo period_desc from ISIL.TAB_PERIODOS_NIVEL 
                  where CNIVEL = 'HA' ORDER BY CPERIODO DESC";*/

        $query = "SELECT STVTERM_CODE period_val,STVTERM_CODE ||' - '|| STVTERM_DESC period_desc  from STVTERM WHERE  
                    SUBSTR(STVTERM_CODE,5,2)  in ('00', '10', '20') ORDER BY STVTERM_CODE DESC ";

        $items = DB::connection('oracle')->select($query);

        return response($items, Response::HTTP_OK);
    }

    public function getPrograms()
    {
        $response = Programs::select(DB::RAW("majr_code, concat(majr_code, ' - ' , program_name) name"))->get();

        return response($response->jsonSerialize(), Response::HTTP_OK);
    }

    public function getConfiguration(Request $request)
    {
        $items = Variables::getConfigTermCode();

        return response($items, Response::HTTP_OK);
    }

    public function getCurrentTermCode()
    {
        $items = Variables::where('name', 'term_code')
            ->select(DB::RAW("defaultvalue as termcode, descripcion"))->first();

        //dd($items);
        return response($items, Response::HTTP_OK);
        // Llamada al procedimiento almacenado usando Eloquent y DB
        /*$pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISILNET_GET_PERIODO_ACTUAL(:cursor); END;");
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);

        // Ejecutar la llamada al procedimiento almacenado
        $stmt->execute();

        oci_execute($cursor);
        oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        //dd($data);
        return response()->json(['result' => $data[0]]);*/
    }

    public function getTypeObservation()
    {

        $query = "select 1 ORDEN,STVCTYP_DESC DEC, STVCTYP_CODE TIPO
            from STVCTYP
            where STVCTYP_CODE='ENP'
            union all
            select 2, STVCTYP_DESC DEC, STVCTYP_CODE TIPO
            from STVCTYP
            where STVCTYP_CODE<>'ENP'
            order by 1";

        $items = DB::connection('oracle')->select($query);

        return response($items, Response::HTTP_OK);
    }

    public function getTypePaymentsHarson()
    {
        $query = "SELECT distinct TBBDETC_DETAIL_CODE codigo, TBBDETC_DESC descr  
                from tbbdetc
                where 
                    tbbdetc_detail_code LIKE 'H%' and tbbdetc_detail_code NOT IN ('REGI') order by TBBDETC_DETAIL_CODE";

        $items = DB::connection('oracle')->select($query);

        return response($items, Response::HTTP_OK);
    }

    public function getUsers(Request $request)
    {

        $query = "SELECT tbraccd_user nomuser FROM(SELECT distinct tbraccd_user 
            from tbraccd
            where tbraccd_entry_date between to_date('" . $request['from_date'] . "', 'yyyy-mm-dd') 
            and to_date('" . $request['to_date'] . "', 'yyyy-mm-dd') 
            order by tbraccd_user asc) tabla
        ";
        $items = DB::connection('oracle')->select($query);

        return response($items, Response::HTTP_OK);
    }

    public function getStatusSolicitud()
    {
        $query = "select STVAPST_CODE codigo, INITCAP(STVAPST_DESC) descr from stvapst";
        $items = DB::connection('oracle')->select($query);

        return response($items, Response::HTTP_OK);
    }

    public function getPaymentMethods()
    {
        $response = PaymentMethods::get();
        return response($response->jsonSerialize(), Response::HTTP_OK);
    }
}
