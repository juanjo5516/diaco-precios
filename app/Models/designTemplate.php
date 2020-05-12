<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class designTemplate extends Model
{
   
    public $timestamps = false;
    protected $fillable = [
        'code', 'idProducto', 'idTipoVerificacion', 'idCategoria','created_at','idMedida'
    ];
    protected $table = 'diaco_asignar_productos_categoria';

}
