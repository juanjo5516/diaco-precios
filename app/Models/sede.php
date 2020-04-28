<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sede extends Model
{
    protected $table = 'diaco_sede';
    
    protected $primarykey = 'id_diaco_sede';
    
    protected $fillable = [
		'nombre_sede',
		'id_diaco_sede'
    ];
    
    Protected $appends = [
         'code', 'name'
     ];

    Protected $visible = ['name', 'code'] ;

    Public function getCodeAttribute()
    {
    	return $this->id_diaco_sede;
    }
    
    Public function getNameAttribute()
    {
    	return $this->nombre_sede;
    }
}