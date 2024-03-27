<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CuotasFechas extends Model
{
    use HasFactory;

    protected $table = 'cuotas_fechas';

    protected $fillable = [
        'cuota_id',
        'nombre',
        'num',
        'fecha_emision',
        'fecha_vencimiento',
        'dif_dias',
        'term_code',
        'user_id'
       ];
   

    public static function boot()
    {
        parent::boot();

        static::creating(function ($table) {
            $table->user_id = Auth::user()->id;
        });

        static::updating(function ($table) {
            $table->user_id = Auth::user()->id;
        });
    }

       
}
