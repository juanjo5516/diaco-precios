<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GasPropano extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];

    protected $table = 'diaco_propano_cba';
}
