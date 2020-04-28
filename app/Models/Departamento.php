<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamento';
    protected $fillable = [
        'nombre_departamento',
        'codigo_departamento'
    ];
    public function municipio()
	{
		return $this->hasMany('App\Models\Municipio','codigo_departamento','codigo_departamento');
    }
    
    public function sede()
    {
        return $this->hasManyThrough('App\Models\sede','App\Models\Municipio','codigo_departamento','codigo_municipio','codigo_departamento','codigo_municipio');
    }
}
