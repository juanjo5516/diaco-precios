<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class smarket extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'code', 'name','address','status'
    ];
    protected $table = 'diaco_smercado_cba';
}
