<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Docentes extends Model
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

        $query = "SELECT 
                    UNIQUE  
                    SPRIDEN_ID documento,
                    SPRIDEN_PIDM pidm,
                    SPRIDEN_LAST_NAME last_name,
                    SPRIDEN_FIRST_NAME first_name, 
                    SPRIDEN_LAST_NAME || ', ' ||SPRIDEN_FIRST_NAME full_name,
                    mailhar.GOREMAL_EMAIL_ADDRESS email,
                    mailper.GOREMAL_EMAIL_ADDRESS email_per,
                    'DOCENTE' rol,
                    SPBPERS_SSN ssn
                FROM SPRIDEN 
                    -- INNER JOIN GORIROL ON GORIROL_PIDM = SPRIDEN_PIDM AND GORIROL_ROLE = 'FACULTY'
                    INNER JOIN SIBINST ON SIBINST_PIDM = SPRIDEN_PIDM 
                    LEFT JOIN GOREMAL mailhar ON mailhar.GOREMAL_PIDM = SPRIDEN_PIDM AND mailhar.GOREMAL_EMAIL_ADDRESS like '%harson%' -- AND GOREMAL_EMAL_CODE='ETRA'
                    LEFT JOIN GOREMAL mailper ON mailper.GOREMAL_PIDM = SPRIDEN_PIDM 
                        AND mailper.GOREMAL_EMAIL_ADDRESS not like '%harson%' AND mailper.GOREMAL_EMAL_CODE ='EPE1' -- AND GOREMAL_EMAL_CODE='ETRA'
                    INNER JOIN SPBPERS ON SPBPERS_PIDM = SPRIDEN_PIDM 
                WHERE SPRIDEN_CHANGE_IND IS NULL
                AND SPRIDEN_ID LIKE 'H%'
                
                ";

            if(!empty($request['ssn'])) {
                $query.= " AND SPBPERS_SSN like '%".$request['ssn']."%' ";
            }

            if(!empty($request['last_name'])) {
                $query.= " AND UPPER(SPRIDEN_LAST_NAME) like '%' || UPPER('".trim($request['last_name'])."') || '%'  ";
            }
    
            if(!empty($request['first_name'])) {
                $query.= " AND UPPER(SPRIDEN_FIRST_NAME) like '%' || UPPER('".trim($request['first_name'])."') || '%'  ";
            }
            //dd($query);
            $count = "Select count(*) total from (".$query.")";
            
            $query.=" ORDER BY SPRIDEN_ACTIVITY_DATE DESC
                        OFFSET ".$init." ROWS FETCH NEXT ".$itemsPerPage." ROWS ONLY ";
            return ["data" => DB::connection('oracle')->select($query) , 
                    'rows' => DB::connection('oracle')->select($count)[0]->total ];

    }
}
