<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Exports\ClientesExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::query();
        if ($request->filled('nombre')) {
            $query->where('nombre', 'ILIKE', "%{$request->nombre}%");
        }
        if ($request->filled('rfc')) {
            $query->where('rfc', 'ILIKE', "%{$request->rfc}%");
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $clientes = $query->orderBy('id', 'desc')->paginate(15);
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'        => 'required|string|max:255',
            'rfc'           => 'nullable|string|max:20',
            'direccion'     => 'nullable|string|max:255',
            'contacto'      => 'nullable|string|max:255',
            'tipo_cliente'  => 'nullable|string|max:50',
            'limite_credito'=> 'nullable|numeric',
            'saldo'         => 'nullable|numeric',
            'ejecutivo_id'  => 'nullable|integer',
            'status'        => 'nullable|string|max:50',
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
        ]);
        Cliente::create($validated);
        return redirect()->route('clientes.index')->with('success', 'Cliente creado correctamente');
    }

    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre'        => 'required|string|max:255',
            'rfc'           => 'nullable|string|max:20',
            'direccion'     => 'nullable|string|max:255',
            'contacto'      => 'nullable|string|max:255',
            'tipo_cliente'  => 'nullable|string|max:50',
            'limite_credito'=> 'nullable|numeric',
            'saldo'         => 'nullable|numeric',
            'ejecutivo_id'  => 'nullable|integer',
            'status'        => 'nullable|string|max:50',
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
        ]);
        $cliente->update($validated);
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente');
    }

    public function exportExcel(Request $request)
{
    $filters = $request->only(['nombre', 'rfc', 'status']);
    return Excel::download(new ClientesExport($filters), 'clientes.xlsx');
}

public function exportPDF(Request $request)
{
    $query = Cliente::query();
    if ($request->filled('nombre')) {
        $query->where('nombre', 'ILIKE', "%{$request->nombre}%");
    }
    if ($request->filled('rfc')) {
        $query->where('rfc', 'ILIKE', "%{$request->rfc}%");
    }
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    $clientes = $query->orderBy('id', 'desc')->get();

    $pdf = PDF::loadView('clientes.export_pdf', compact('clientes'));
    return $pdf->download('clientes.pdf');
}
}
