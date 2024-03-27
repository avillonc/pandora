<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Periods extends Model
{
    use HasFactory;

    public static function getDatesFromTermCode($termcode = null)
    {
        $query ="SELECT STVTERM_START_DATE, STVTERM_END_DATE 
                from STVTERM WHERE  STVTERM_CODE ='".$termcode."' ";
         
        return DB::connection('oracle')->selectOne($query);
    }
    
}
