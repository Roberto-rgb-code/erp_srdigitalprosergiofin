<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // <-- AGREGA ESTA LÍNEA
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    // ...
}
