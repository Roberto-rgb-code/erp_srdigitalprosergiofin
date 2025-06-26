<?php

namespace App\Http\Controllers;

use App\Models\Credito;
use App\Models\Cliente;
use Illuminate\Http\Request;

class CreditoController extends Controller
{
    public function index()
    {
        $creditos = Credito::with('cliente')->orderByDesc('id')->paginate(20);
        return view('creditos.index', compact('creditos'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('creditos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id'      => 'required|exists:clientes,id',
            'linea_total'     => 'required|numeric|min:0',
            'saldo_actual'    => 'nullable|numeric|min:0',
            'linea_usada'     => 'nullable|numeric|min:0',
            'status_credito'  => 'required|string|max:50',
            'tiempo_credito'  => 'required|integer|min:1',
            'semaforo'        => 'nullable|string|max:10',
            'especificaciones'=> 'nullable|string|max:1000',
        ]);

        // Línea usada y saldo actuales opcionales
        $data['linea_usada'] = $data['linea_usada'] ?? 0;
        $data['saldo_actual'] = $data['saldo_actual'] ?? 0;

        $credito = Credito::create($data);
        return redirect()->route('creditos.show', $credito)->with('success', 'Crédito creado correctamente.');
    }

    public function show(Credito $credito)
    {
        $credito->load(['cliente', 'documentos']);
        return view('creditos.show', compact('credito'));
    }

    public function edit(Credito $credito)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('creditos.edit', compact('credito', 'clientes'));
    }

    public function update(Request $request, Credito $credito)
    {
        $data = $request->validate([
            'cliente_id'      => 'required|exists:clientes,id',
            'linea_total'     => 'required|numeric|min:0',
            'saldo_actual'    => 'nullable|numeric|min:0',
            'linea_usada'     => 'nullable|numeric|min:0',
            'status_credito'  => 'required|string|max:50',
            'tiempo_credito'  => 'required|integer|min:1',
            'semaforo'        => 'nullable|string|max:10',
            'especificaciones'=> 'nullable|string|max:1000',
        ]);

        $data['linea_usada'] = $data['linea_usada'] ?? 0;
        $data['saldo_actual'] = $data['saldo_actual'] ?? 0;

        $credito->update($data);
        return redirect()->route('creditos.show', $credito)->with('success', 'Crédito actualizado correctamente.');
    }

    public function destroy(Credito $credito)
{
    // Elimina todos los documentos asociados (y sus archivos)
    foreach ($credito->documentos as $doc) {
        if ($doc->archivo && \Storage::disk('public')->exists($doc->archivo)) {
            \Storage::disk('public')->delete($doc->archivo);
        }
        $doc->delete();
    }

    $credito->delete();
    return redirect()->route('creditos.index')->with('success', 'Crédito eliminado correctamente.');
}


}
