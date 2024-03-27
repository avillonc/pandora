<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Variables;

class ServiceController extends Controller
{


    public function index(Request $request)
    {

        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISILNET_GET_DOCUMENTOS(:cursor); END;");
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);

        // Ejecutar la llamada al procedimiento almacenado
        $stmt->execute();
        oci_execute($cursor);
        oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($cursor);
        $stmt->closeCursor();

        return response($data, Response::HTTP_OK);
    }

    public function show($dni)
    {   

        $ruta_img = storage_path('formatos')."/".$dni.".png";

        if(file_exists($ruta_img)) {
            // Read image path, convert to base64 encoding
            $imageData = base64_encode(file_get_contents($ruta_img));
            
            // Format the image SRC:  data:{mime};base64,{data};
            $src = 'data: '.mime_content_type($ruta_img).';base64,'.$imageData;
        } else {
            $src = null;
        }

        return $src;
    }

    public function store(Request $request)
    {   

        $pidm = $request->session()->get('pidm');
        $termCode  = isset($request->major_code) ? $request->major_code['SORLFOS_TERM_CODE'] : '-';

        //FALTA OBTENER EL PERIODO ELEGIDO HACER UN RETURN OBJET Y UN UPDATE V-MODEL

        $detail_code  = isset($request->service) ? $request->service : null;
        $majr_code  = isset($request->major_code) ? $request->major_code['SORLFOS_MAJR_CODE']  : '-';
        $sempresa  = isset($request->organization) ? $request->organization : null;
        $sdestinatario  = isset($request->coordinator) ? $request->coordinator : null;
        $scargo_destinatario  = isset($request->job) ? $request->job : null;

        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_GENERA_SOLICITUD(:pidm, :detail_code,:majr_code,:sempresa,
            :sdestinatario,:scargo_destinatario,:sterm_code); END;");
        
        $stmt->bindParam(':pidm', $pidm, \PDO::PARAM_STR);
        $stmt->bindParam(':detail_code', $detail_code, \PDO::PARAM_STR);
        $stmt->bindParam(':majr_code', $majr_code, \PDO::PARAM_STR);
        $stmt->bindParam(':sempresa', $sempresa, \PDO::PARAM_STR);
        $stmt->bindParam(':sdestinatario', $sdestinatario, \PDO::PARAM_STR);
        $stmt->bindParam(':scargo_destinatario', $scargo_destinatario, \PDO::PARAM_STR);
        $stmt->bindParam(':sterm_code', $termCode, \PDO::PARAM_STR);
     
        $stmt->execute();

        $precio = DB::connection('oracle')->selectOne("select TBBDETC_AMOUNT from TBBDETC 
            where TBBDETC_DETAIL_CODE='" . $detail_code . "'");

        DB::connection('sqlsrv')->select("execute sp_inserta_certificado " . $pidm .",'". $detail_code . "'," . $precio->tbbdetc_amount);

        return response([], Response::HTTP_OK); 
    }

    public function update(Request $request, $id)
    {
        //
    }

     public function getDatosConfirmar(Request $request)
    {   
        $pidm = $request->session()->get('pidm');

        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISILNET_GET_DATA_CONFIRMACION(:pidm, :cursor, :cursor2); END;");
        $stmt->bindParam(':pidm', $pidm, \PDO::PARAM_STR);
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);
        $stmt->bindParam(':cursor2', $cursor2, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);

        // Ejecutar la llamada al procedimiento almacenado
        $stmt->execute();
        oci_execute($cursor);
        oci_fetch_all($cursor, $entity, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($cursor);

        oci_execute($cursor2);
        oci_fetch_all($cursor2, $entity2, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($cursor2);

        $stmt->closeCursor();

        $data['identity'] = empty($entity[0]) ? [] : $entity[0];

        $data['majors'] = empty($entity2) ? [] : $entity2;

        return response(json_decode(json_encode($data),true), Response::HTTP_OK);
    }

}
