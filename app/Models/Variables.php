<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Variables extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'name',
        'defaultvalue'
    ];

    public static function getConfigTermCode()
    {
        $items = Variables::where('name', 'term_code')
            ->select(DB::RAW("defaultvalue as termcode"))->first();
         
        return $items;
    }

}
