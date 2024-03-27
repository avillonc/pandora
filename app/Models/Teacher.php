<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Teacher extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'docentes';

    protected $fillable = [
        'nombres',
        'apellidos',
        'documento',
        'email_harson',
        'email',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public static function listarDocentes($request)
    {
        //dd($request);
        $page = $request['page'];
        $itemsPerPage = $request['itemsPerPage'];
        //$itemsPerPage = 1;
        $init = ($page - 1) * $itemsPerPage;

        $query = "SELECT tabla.*, (CASE WHEN celular is null THEN telefcasa ELSE celular END) as cell_phone FROM (SELECT 
                    UNIQUE  
                    SPRIDEN_ID documento,
                    SPRIDEN_PIDM pidm,
                    SPRIDEN_LAST_NAME last_name,
                    SPRIDEN_FIRST_NAME first_name, 
                    SPRIDEN_LAST_NAME || ', ' ||SPRIDEN_FIRST_NAME full_name,
                    -- mailhar.GOREMAL_EMAIL_ADDRESS email,
                    -- mailper.GOREMAL_EMAIL_ADDRESS email_per,
                    (select GOREMAL_EMAIL_ADDRESS from GOREMAL where 
                        GOREMAL_PIDM = SPRIDEN_PIDM AND 
                        (GOREMAL_EMAIL_ADDRESS like '%harson%' OR GOREMAL_EMAL_CODE='ETRA')
                        AND rownum<2) email_harson ,
                    (select GOREMAL_EMAIL_ADDRESS from GOREMAL where 
                        GOREMAL_PIDM = SPRIDEN_PIDM 
                        AND GOREMAL_EMAL_CODE ='EPE1'
                        AND rownum<2) email,
                    'DOCENTE' rol,
                    SPBPERS_SSN ssn,
                    SPBPERS_SEX gender,
                    telef.SPRTELE_PHONE_NUMBER celular,
                    telefcasa.SPRTELE_PHONE_NUMBER telefcasa,
                    SPRIDEN_ACTIVITY_DATE
                FROM SPRIDEN 
                    -- INNER JOIN GORIROL ON GORIROL_PIDM = SPRIDEN_PIDM AND GORIROL_ROLE = 'FACULTY'
                    INNER JOIN SIBINST ON SIBINST_PIDM = SPRIDEN_PIDM 
                    --LEFT JOIN GOREMAL mailhar ON mailhar.GOREMAL_PIDM = SPRIDEN_PIDM AND (mailhar.GOREMAL_EMAIL_ADDRESS like '%harson%' OR GOREMAL_EMAL_CODE='ETRA') 
                    -- LEFT JOIN GOREMAL mailper ON mailper.GOREMAL_PIDM = SPRIDEN_PIDM 
                        -- AND mailper.GOREMAL_EMAIL_ADDRESS not like '%harson%' 
                        --AND mailper.GOREMAL_EMAL_CODE ='EPE1'
                    INNER JOIN SPBPERS ON SPBPERS_PIDM = SPRIDEN_PIDM 
                    LEFT JOIN SPRTELE telef ON telef.SPRTELE_PIDM = SPRIDEN_PIDM  AND  telef.SPRTELE_TELE_CODE = 'M1' 
                    LEFT JOIN SPRTELE telefcasa ON telefcasa.SPRTELE_PIDM = SPRIDEN_PIDM  AND  telefcasa.SPRTELE_TELE_CODE = 'CA' 
               
                WHERE SPRIDEN_CHANGE_IND IS NULL
                AND SPRIDEN_ID LIKE 'H%') tabla where 1=1
                ";
        //dd($query);
        if (!empty($request['ssn'])) {
            $query .= " AND ssn like '%" . $request['ssn'] . "%' ";
        }

        if (!empty($request['last_name'])) {
            $query .= " AND UPPER(SPRIDEN_LAST_NAME) like '%' || UPPER('" . trim($request['last_name']) . "') || '%'  ";
        }

        if (!empty($request['first_name'])) {
            $query .= " AND UPPER(SPRIDEN_FIRST_NAME) like '%' || UPPER('" . trim($request['first_name']) . "') || '%'  ";
        }
        //dd($query);
        $count = "Select count(*) total from (" . $query . ")";

        $query .= " ORDER BY SPRIDEN_ACTIVITY_DATE DESC
                        OFFSET " . $init . " ROWS FETCH NEXT " . $itemsPerPage . " ROWS ONLY ";
        return [
            "data" => DB::connection('oracle')->select($query),
            'rows' => DB::connection('oracle')->select($count)[0]->total
        ];
    }
}
