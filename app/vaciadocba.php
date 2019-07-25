<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vaciadocba extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'created_at','idPlantilla', 'idVerificador','tipoVerificacion','idLugarVisita','idEstablecimientoVisita','numeroLocal','idProducto','idMedida','precioProducto','estado'
    ];

    protected $table = 'diaco_vaciadocba';
}
