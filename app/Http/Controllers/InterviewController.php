<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Variables;

class InterviewController extends Controller
{


    public function index(Request $request)
    {
        $data = [];
        $pidm = $request->session()->get('pidm');
        //$term_code = '202310'; //Variables::getConfigTermCode()->termcode;
        $term_code = Variables::getConfigTermCode()->termcode;
        $tipo = 'E';

        $data['term_code'] = $term_code;

        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISILNET_GET_DATA_ENCUESTA(:pidm, :termcode,:tipo, :cursor, 
            :cursor2, :cursor3, :cursor4); END;");
        $stmt->bindParam(':pidm', $pidm, \PDO::PARAM_STR);
        $stmt->bindParam(':termcode', $term_code, \PDO::PARAM_STR);
        $stmt->bindParam(':tipo', $tipo, \PDO::PARAM_STR);
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
        $stmt->bindParam(':cursor2', $cursor2, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
        $stmt->bindParam(':cursor3', $cursor3, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
        $stmt->bindParam(':cursor4', $cursor4, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);

        // Ejecutar la llamada al procedimiento almacenado
        $stmt->execute();
        oci_execute($cursor);
        oci_fetch_all($cursor, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($cursor);

        oci_execute($cursor2);
        oci_fetch_all($cursor2, $result2, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($cursor2);

        oci_execute($cursor3);
        oci_fetch_all($cursor3, $result3, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($cursor3);

        oci_execute($cursor4);
        oci_fetch_all($cursor4, $result4, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($cursor4);

        $stmt->closeCursor();

        if (empty($result[0]) || $result[0]['SSTADO'] == 'I') {
            return $this->sendError('No hay Encuesta registrada en el periodo ' . $term_code . '.');
        } else {
            $data['dates'] = $result[0];
        }

        $data['questions'] = empty($result2[0]) ? [] : $result2[0];

        if (empty($result3[0])) {
            $data['answer'] = [
                'DPREG1' => null,
                'DPREG2' => null,
                'DPREG3' => null,
                'DPREG4' => null,
                'DPREG5' => null,
                'DPREG6' => null,
                'DPREG7' => null,
                'DPREG8' => null,
                'DPREG9' => null,
            ];
        } else {
            $data['answer']  = $result3[0];
        }

        $data['options'] = empty($result4) ? [] : $result4;

        return response($data, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        //dd($request->all());

        $pidm = $request->session()->get('pidm');
        $termCode  = $request->termCode;
        $dpreg1 = $request->answer['DPREG1'];
        $dpreg2 = $request->answer['DPREG2'];
        $dpreg3 = $request->answer['DPREG3'];
        $dpreg4 = $request->answer['DPREG4'];
        $dpreg5 = $request->answer['DPREG5'];
        $dpreg6 = $request->answer['DPREG6'];
        $dpreg7 = $request->answer['DPREG7'];
        $dpreg8 = $request->answer['DPREG8'];
        $dpreg9 = $request->answer['DPREG9'];
        $srepu = 'E';

        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ACT_ENTREVISTA(:pidm, :term_code,:dres1,
            :dres2,:dres3,:dres4,:dres5,:dres6,:dres7,:dres8,:dres9, :srepu); END;");

        $stmt->bindParam(':pidm', $pidm, \PDO::PARAM_STR);
        $stmt->bindParam(':term_code', $termCode, \PDO::PARAM_STR);
        $stmt->bindParam(':dres1', $dpreg1, \PDO::PARAM_STR);
        $stmt->bindParam(':dres2', $dpreg2, \PDO::PARAM_STR);
        $stmt->bindParam(':dres3', $dpreg3, \PDO::PARAM_STR);
        $stmt->bindParam(':dres4', $dpreg4, \PDO::PARAM_STR);
        $stmt->bindParam(':dres5', $dpreg5, \PDO::PARAM_STR);
        $stmt->bindParam(':dres6', $dpreg6, \PDO::PARAM_STR);
        $stmt->bindParam(':dres7', $dpreg7, \PDO::PARAM_STR);
        $stmt->bindParam(':dres8', $dpreg8, \PDO::PARAM_STR);
        $stmt->bindParam(':dres9', $dpreg9, \PDO::PARAM_STR);
        $stmt->bindParam(':srepu', $srepu, \PDO::PARAM_STR);

        // Ejecutar la llamada al procedimiento almacenado
        $stmt->execute();

        return response([], Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {

        //
    }
}
