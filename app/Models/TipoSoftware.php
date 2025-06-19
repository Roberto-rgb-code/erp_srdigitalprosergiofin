<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoSoftware extends Model
{
    protected $table = 'tipo_software';
    protected $fillable = ['nombre'];
    public $timestamps = false;
}
