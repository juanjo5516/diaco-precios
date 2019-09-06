<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class local extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'nombreEstablecimiento', 'direccionEstablecimiento'
    ];
    protected $table = 'diaco_establecimientocba';
}
