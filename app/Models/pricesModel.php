<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pricesModel extends Model
{
    
    protected $fillable = [
        'code',
        'articulo',
        'medida',
        'fecha_actual',
        'price',
        'fecha_anterior',
        'prices'
    ];
}
