<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NameTemplate extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'NombreTemplate', 'estado'
    ];


    protected $table = 'NAME_TEMPLATE_CBA';
}
