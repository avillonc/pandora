<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;  
use App\Models\Data; 

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

    public function getMaestras(Request $request)
    {
        $data = Data::getMaestras($request);
        return response($data, Response::HTTP_OK);
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

 
}
