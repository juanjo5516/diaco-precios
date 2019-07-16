<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NameTemplate extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'NombreTemplate', 'estado'
    ];


    protected $table = 'diaco_name_template_cba';
}
