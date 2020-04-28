<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioSistema extends Model
{

    public $timestamps = false;
    protected $fillable = [
        'code_user', 'code_sede','status'
    ];
    protected $table = 'diaco_usuarios_cba';
}
