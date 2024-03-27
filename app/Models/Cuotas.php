<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cuotas extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'cuotas';

    protected $fillable = [
        'payment_method_id',
        'program_id',
        'num_cuotas',
        'deleted_at',
        'created_at',
        'updated_at',
       ];
   
       protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
       ];
       
    public static function cuotasGeneradas(Request $request)
    {  
        $query ="SELECT TBRACCD_TRAN_NUMBER, 
                TBRACCD_TERM_CODE, 
                TBRACCD_DETAIL_CODE, 
                TBRACCD_USER, 
                TBRACCD_ENTRY_DATE, 
                to_char(TBRACCD_ENTRY_DATE,'DD/MM/YYYY') entry_date,
                TBRACCD_AMOUNT, 
                TBRACCD_BALANCE, 
                to_char(TBRACCD_EFFECTIVE_DATE,'DD/MM/YYYY') eff_date 
            FROM TBRACCD 
            WHERE TBRACCD_PIDM = " . $request->pidm . " 
                AND TBRACCD_TERM_CODE = " . $request->term_code . " 
                AND TBRACCD_DATA_ORIGIN = 'HARSON MANAGER' 
            ORDER BY TBRACCD_TRAN_NUMBER ASC";
        return DB::connection('oracle')->select($query);
    }

    public static function tieneCuotasPagadas(Request $request)
    {  
        $query ="SELECT 
            TBRACCD_DETAIL_CODE,(TBRACCD_AMOUNT - TBRACCD_BALANCE) pagado 
        FROM tbraccd 
            WHERE TBRACCD_DATA_ORIGIN = 'HARSON MANAGER'  
            AND TBRACCD_PIDM = " . $request->pidm . " 
            AND TBRACCD_BALANCE < TBRACCD_AMOUNT
        ORDER BY TBRACCD_TRAN_NUMBER ASC";
        return DB::connection('oracle')->select($query);
    }  
}
