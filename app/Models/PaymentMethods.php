<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethods extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $table = 'payment_method';

    protected $fillable = [
        'id',
        'descripcion',
       ];
   
       protected $dates = [
        'created_at',
        'updated_at',
        //'start_date',
        //'anticipated_end_date'
       ];
}
