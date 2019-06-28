<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListarAsignacion extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'idPlantilla', 'idSede','created_at','estatus'
    ];


    protected $table = 'AsignarSedeCBA';
}
