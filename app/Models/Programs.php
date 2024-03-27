<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programs extends Model
{
    use HasFactory;
    //use SoftDeletes;
    public $timestamps = false;

    protected $table = 'programs';

    protected $fillable = [
        'program_name',
        'majr_code',
        'majr_code',
        'master_bachiller'    
       ];
   
       protected $dates = [
           'payment_date',
       ];
}
