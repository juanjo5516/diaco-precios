<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'nombre'
    ];
    protected $table = 'diaco_productocba';
}
