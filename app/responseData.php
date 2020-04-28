<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class responseData extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'codeProducto','nameProducto','codeMedida','nameMedida'
    ];
    // protected $table = 'diaco_categoriacba';

}
