<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DatoFiscalCliente; // O el modelo que tengas para datos fiscales

class DatoFiscalClienteController extends Controller
{
    public function show($id)
    {
        $datoFiscal = \App\Models\DatoFiscalCliente::findOrFail($id);
        // Vista en resources/views/datos_fiscales/show.blade.php
        return view('datos_fiscales.show', compact('datoFiscal'));
    }
}
