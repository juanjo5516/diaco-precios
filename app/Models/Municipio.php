<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
	protected $table = 'municipio';
    protected $fillable = [
		'nombre_municipio',
		'codigo_municipio'
	];
	protected $primarykey = 'codigo_municipio';

	public function departamento()
	{
		return $this->belongsTo('App\Models\Departamento');
	}
}
