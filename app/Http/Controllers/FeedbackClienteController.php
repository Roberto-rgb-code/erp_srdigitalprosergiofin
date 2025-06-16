<?php

namespace App\Http\Controllers;

use App\Models\FeedbackCliente;
use App\Models\ModuloSoftware;
use Illuminate\Http\Request;

class FeedbackClienteController extends Controller
{
    public function index($proyecto, $modulo)
    {
        $modulo = ModuloSoftware::findOrFail($modulo);
        $feedbacks = $modulo->feedbacks()->get();
        return view('feedback_cliente.index', compact('modulo', 'feedbacks', 'proyecto'));
    }

    public function store(Request $request, $proyecto, $modulo)
    {
        $validated = $request->validate([
            'comentario' => 'required|string',
            'fecha'      => 'nullable|date'
        ]);
        $validated['modulo_software_id'] = $modulo;
        FeedbackCliente::create($validated);
        return back()->with('success', 'Comentario registrado');
    }

    public function destroy($proyecto, $modulo, FeedbackCliente $feedback)
    {
        $feedback->delete();
        return back()->with('success', 'Comentario eliminado');
    }
}
