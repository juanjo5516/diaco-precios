<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class market extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'idMercado', 'nombreMercado','direccionMercado','status'
    ];
    protected $table = 'diaco_mercadocba';
}
