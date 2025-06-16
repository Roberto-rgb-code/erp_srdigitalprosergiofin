<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoProyecto extends Model
{
    protected $table = 'tipo_proyecto';
    protected $fillable = ['nombre'];
    public $timestamps = false;
}
