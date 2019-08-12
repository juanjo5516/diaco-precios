<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoVisitaPlantilla extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'nombreVerificacion'
    ];

    protected $table = 'diaco_tipoverificacioncba';
}


