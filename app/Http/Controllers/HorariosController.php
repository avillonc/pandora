<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Variables;

class HorariosController extends Controller
{
    public function getNrcs(Request $request)
    {
        //dd(auth()->user()->dni);
        $dni = auth()->user()->dni;
        //$periodo = $request['periodo'];
        $periodo = Variables::getConfigTermCode()->termcode;
        //$dni = '75212324';
        //$periodo = '202320';
        //dd($periodo);

        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISILNET_GET_HORARIOS_NRCS(:dni, :periodo, :cursor); END;");
        $stmt->bindParam(':dni', $dni, \PDO::PARAM_STR);
        $stmt->bindParam(':periodo', $periodo, \PDO::PARAM_STR);
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
        //$stmt->bindParam(':cursor2', $cursor2, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);

        // Ejecutar la llamada al procedimiento almacenado
        $stmt->execute();
        oci_execute($cursor);
        oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($cursor);
        $stmt->closeCursor();
        return [
            "data" => $data,
            'rows' => count($data)
        ];
    }

    public function getHorarios(Request $request)
    {
        //$dni = auth()->user()->dni;

        //$periodo = '202320';
        //$periodo = $request['periodo'];
        $periodo = Variables::getConfigTermCode()->termcode;
        $pidm = $request->session()->get('pidm');
        //$pidm = '212022';
        //$periodo = '202320';
        /*$pdo = DB::connection('oracle')->getPdo();
        //$stmt = $pdo->prepare("BEGIN ISIL.SP_ISILNET_GET_HORARIOS(:dni, :periodo, :cursor); END;");
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISILNET_GET_HORARIOS(:pidm, :periodo, :cursor); END;");
        //$stmt->bindParam(':dni', $dni, \PDO::PARAM_STR);
        $stmt->bindParam(':pidm', $pidm, \PDO::PARAM_STR);
        $stmt->bindParam(':periodo', $periodo, \PDO::PARAM_STR);
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
        //$stmt->bindParam(':cursor2', $cursor2, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);

        // Ejecutar la llamada al procedimiento almacenado
        $stmt->execute();
        oci_execute($cursor);
        oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($cursor);
        $stmt->closeCursor();
        //dd($data);
        return [
            "data" => $data,
            'rows' => count($data)
        ];*/

        $query = "select substr(Hora,1,2)||':'||substr(Hora,3,2) Horario, 
        (select SSRMEET_CRN||'_'||SCRSYLN_LONG_COURSE_TITLE||'_'||SSRMEET_BLDG_CODE||SSRMEET_ROOM_CODE 
        from SSRMEET, SFRSTCR,SSBSECT,SCRSYLN 
        where (Hora>=SSRMEET_BEGIN_TIME and Hora<SSRMEET_END_TIME) AND 
           SSBSECT_CRN=SSRMEET_CRN                              AND 
           SSRMEET_TERM_CODE=SSBSECT_TERM_CODE                  AND 
           SSBSECT_CRSE_NUMB=SCRSYLN_CRSE_NUMB                  AND 
           SSRMEET_TERM_CODE = '$periodo'       AND 
           SSRMEET_MON_DAY   = 'M'                              and 
           SFRSTCR_PIDM      = '$pidm'            and 
           rownum=1                                             and 
           SSRMEET_CRN=SFRSTCR_CRN                              and 
           SFRSTCR_TERM_CODE = SSRMEET_TERM_CODE                and 
           SSRMEET_MTYP_CODE = 'CLAS'                           and 
           /*substr(SFRSTCR_RSTS_CODE,1,1) not in ('D','C')*/    SFRSTCR_RSTS_CODE in ('RD','RE','RM','RW','RZ')) Lun, 
        (select SSRMEET_CRN||'_'||SCRSYLN_LONG_COURSE_TITLE||'_'||SSRMEET_BLDG_CODE||SSRMEET_ROOM_CODE 
        from SSRMEET, SFRSTCR,SSBSECT,SCRSYLN 
        where (Hora>=SSRMEET_BEGIN_TIME and Hora<SSRMEET_END_TIME) and 
           SSBSECT_CRN=SSRMEET_CRN                              AND 
           SSRMEET_TERM_CODE=SSBSECT_TERM_CODE                  AND 
           SSBSECT_CRSE_NUMB=SCRSYLN_CRSE_NUMB                  AND 
           SSRMEET_TERM_CODE = '$periodo'       and 
           SSRMEET_TUE_DAY   = 'T'                              and 
           SFRSTCR_PIDM      = '$pidm'            and 
           rownum=1                                             and 
           SSRMEET_CRN=SFRSTCR_CRN                              and 
           SFRSTCR_TERM_CODE = SSRMEET_TERM_CODE                and 
           SSRMEET_MTYP_CODE = 'CLAS'                           and 
           /*substr(SFRSTCR_RSTS_CODE,1,1) not in ('D','C')*/    SFRSTCR_RSTS_CODE in ('RD','RE','RM','RW','RZ')) Mar, 
        (select SSRMEET_CRN||'_'||SCRSYLN_LONG_COURSE_TITLE||'_'||SSRMEET_BLDG_CODE||SSRMEET_ROOM_CODE 
        from SSRMEET, SFRSTCR,SSBSECT,SCRSYLN 
        where (Hora>=SSRMEET_BEGIN_TIME and Hora<SSRMEET_END_TIME) and 
           SSBSECT_CRN=SSRMEET_CRN                              AND 
           SSRMEET_TERM_CODE=SSBSECT_TERM_CODE                  AND 
           SSBSECT_CRSE_NUMB=SCRSYLN_CRSE_NUMB                  AND 
           SSRMEET_TERM_CODE = '$periodo'       and 
           SSRMEET_WED_DAY   = 'W'                              and 
           SFRSTCR_PIDM      = '$pidm'            and 
           rownum=1                                             and 
           SSRMEET_CRN=SFRSTCR_CRN                              and 
           SSRMEET_MTYP_CODE = 'CLAS'                           and 
           SFRSTCR_TERM_CODE = SSRMEET_TERM_CODE                and 
           /*substr(SFRSTCR_RSTS_CODE,1,1) not in ('D','C')*/    SFRSTCR_RSTS_CODE in ('RD','RE','RM','RW','RZ')) Mie, 
        (select SSRMEET_CRN||'_'||SCRSYLN_LONG_COURSE_TITLE||'_'||SSRMEET_BLDG_CODE||SSRMEET_ROOM_CODE 
        from SSRMEET, SFRSTCR,SSBSECT,SCRSYLN 
        where (Hora>=SSRMEET_BEGIN_TIME and Hora<SSRMEET_END_TIME) and 
           SSBSECT_CRN=SSRMEET_CRN                              AND 
           SSRMEET_TERM_CODE=SSBSECT_TERM_CODE                  AND 
           SSBSECT_CRSE_NUMB=SCRSYLN_CRSE_NUMB                  AND 
           SSRMEET_TERM_CODE = '$periodo'       and 
           SSRMEET_THU_DAY   = 'R'                              and 
           SFRSTCR_PIDM      = '$pidm'            and 
           rownum=1                                             and 
           SSRMEET_CRN=SFRSTCR_CRN                              and 
           SSRMEET_MTYP_CODE = 'CLAS'                           and 
           SFRSTCR_TERM_CODE = SSRMEET_TERM_CODE                and 
           /*substr(SFRSTCR_RSTS_CODE,1,1) not in ('D','C')*/    SFRSTCR_RSTS_CODE in ('RD','RE','RM','RW','RZ')) Jue, 
        (select SSRMEET_CRN||'_'||SCRSYLN_LONG_COURSE_TITLE||'_'||SSRMEET_BLDG_CODE||SSRMEET_ROOM_CODE 
        from SSRMEET, SFRSTCR,SSBSECT,SCRSYLN 
        where (Hora>=SSRMEET_BEGIN_TIME and Hora<SSRMEET_END_TIME) and 
           SSBSECT_CRN=SSRMEET_CRN                              AND 
           SSRMEET_TERM_CODE=SSBSECT_TERM_CODE                  AND 
           SSBSECT_CRSE_NUMB=SCRSYLN_CRSE_NUMB                  AND 
           SSRMEET_TERM_CODE = '$periodo'       and 
           SSRMEET_FRI_DAY   = 'F'                              and 
           SFRSTCR_PIDM      = '$pidm'           and 
           rownum=1                                             and 
           SSRMEET_CRN=SFRSTCR_CRN                              and 
           SSRMEET_MTYP_CODE = 'CLAS'                           and 
           SFRSTCR_TERM_CODE = SSRMEET_TERM_CODE                and 
           /*substr(SFRSTCR_RSTS_CODE,1,1) not in ('D','C')*/    SFRSTCR_RSTS_CODE in ('RD','RE','RM','RW','RZ')) Vie, 
        (select SSRMEET_CRN||'_'||SCRSYLN_LONG_COURSE_TITLE||'_'||SSRMEET_BLDG_CODE||SSRMEET_ROOM_CODE 
        from SSRMEET, SFRSTCR,SSBSECT,SCRSYLN 
        where (Hora>=SSRMEET_BEGIN_TIME and Hora<SSRMEET_END_TIME) and 
           SSBSECT_CRN=SSRMEET_CRN                              AND 
           SSRMEET_TERM_CODE=SSBSECT_TERM_CODE                  AND 
           SSBSECT_CRSE_NUMB=SCRSYLN_CRSE_NUMB                  AND 
           SSRMEET_TERM_CODE = '$periodo'       and 
           SSRMEET_SAT_DAY   = 'S'                              and 
           SFRSTCR_PIDM      = '$pidm'            and 
           rownum=1                                             and 
           SSRMEET_CRN=SFRSTCR_CRN                              and 
           SSRMEET_MTYP_CODE = 'CLAS'                           and 
           SFRSTCR_TERM_CODE = SSRMEET_TERM_CODE                and 
           /*substr(SFRSTCR_RSTS_CODE,1,1) not in ('D','C')*/    SFRSTCR_RSTS_CODE in ('RD','RE','RM','RW','RZ')) Sab 
        from (select distinct SSRMEET_BEGIN_TIME Hora 
        from SSRMEET 
        where SSRMEET_SCHD_CODE<>'VIR' 
        and   SSRMEET_TERM_CODE = '$periodo' 
        and   SSRMEET_MTYP_CODE = 'CLAS' 
        and   SSRMEET_BEGIN_TIME IS NOT NULL 
        union all 
        select '2200' 
        from dual 
        union all 
        select '2300' 
        from dual ) a 
        order by Hora";

        //dd($query);
        try {
            $data = DB::connection('oracle')->select($query);
            //dd($data);
        } catch (\Exception $e) {
            //dd($e);
        }
        //dd($data);
        //dd($data);
        return [
            "data" => $data,
            'rows' => count($data)
        ];
    }
}
