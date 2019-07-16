<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EdicionPlantilla extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'NombrePlantilla', 'idCategoria', 'idProducto', 'idMedida', 'estado','created_at'
    ];


    protected $table = 'diaco_plantillascba';

    
}