<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Exports\ClientesExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ClienteController extends Controller
{
    // Listado de clientes
    public function index(Request $request)
    {
        $query = Cliente::with('datoFiscal');

        if ($request->filled('nombre')) {
            $query->where('nombre_completo', 'ILIKE', "%{$request->nombre}%")
                  ->orWhere('empresa', 'ILIKE', "%{$request->nombre}%");
        }
        if ($request->filled('rfc')) {
            $query->whereHas('datoFiscal', function($q) use ($request) {
                $q->where('rfc', 'ILIKE', "%{$request->rfc}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $clientes = $query->orderBy('id', 'desc')->paginate(15);

        $allClientes = Cliente::with('datoFiscal')->get();
        $conteoStatus = $allClientes->groupBy('status')->map->count();
        $conteoTipo   = $allClientes->groupBy('tipo_cliente')->map->count();
        $creditoTotal = 0;
        $saldoTotal   = 0;

        return view('clientes.index', compact('clientes', 'conteoStatus', 'conteoTipo', 'creditoTotal', 'saldoTotal'));
    }

    // Formulario crear
    public function create()
    {
        return view('clientes.create');
    }

    // Guardar cliente
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_completo'     => 'required|string|max:255',
            'empresa'             => 'nullable|string|max:255',
            'contacto'            => 'nullable|string|max:255',
            'direccion'           => 'nullable|string|max:255',
            'tipo_cliente'        => 'required|string|max:50',
            'status'              => 'required|string|max:50',

            // Datos fiscales
            'nombre_fiscal'       => 'nullable|string|max:255',
            'rfc'                 => 'nullable|string|max:20',
            'direccion_fiscal'    => 'nullable|string|max:255',
            'uso_cfdi'            => 'nullable|string|max:255',
            'correo'              => 'nullable|email|max:255',
            'regimen_fiscal'      => 'nullable|string|max:255',
        ], [
            'nombre_completo.required' => 'El campo Nombre completo es obligatorio.',
            'tipo_cliente.required'    => 'El campo Tipo de cliente es obligatorio.',
            'status.required'          => 'El campo Estatus es obligatorio.',
        ]);

        if (empty($validated['nombre_completo'])) {
            return back()->withErrors(['nombre_completo' => 'El campo Nombre completo es obligatorio.'])->withInput();
        }

        $cliente = Cliente::create([
            'nombre_completo' => $validated['nombre_completo'],
            'empresa'         => $validated['empresa'] ?? null,
            'contacto'        => $validated['contacto'] ?? null,
            'direccion'       => $validated['direccion'] ?? null,
            'tipo_cliente'    => $validated['tipo_cliente'],
            'status'          => $validated['status'],
        ]);

        // Submódulo: datos fiscales
        if (
            $request->filled('rfc') ||
            $request->filled('nombre_fiscal') ||
            $request->filled('direccion_fiscal') ||
            $request->filled('uso_cfdi') ||
            $request->filled('correo') ||
            $request->filled('regimen_fiscal')
        ) {
            $cliente->datoFiscal()->create([
                'nombre_fiscal'    => $validated['nombre_fiscal'] ?? $validated['nombre_completo'],
                'rfc'              => $validated['rfc'] ?? null,
                'direccion_fiscal' => $validated['direccion_fiscal'] ?? null,
                'uso_cfdi'         => $validated['uso_cfdi'] ?? null,
                'correo'           => $validated['correo'] ?? null,
                'regimen_fiscal'   => $validated['regimen_fiscal'] ?? null,
            ]);
        }

        return redirect()->route('clientes.index')->with('success', 'Cliente creado correctamente');
    }

    // Detalle de cliente
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    // Formulario editar
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    // Actualizar cliente
    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre_completo'     => 'required|string|max:255',
            'empresa'             => 'nullable|string|max:255',
            'contacto'            => 'nullable|string|max:255',
            'direccion'           => 'nullable|string|max:255',
            'tipo_cliente'        => 'required|string|max:50',
            'status'              => 'required|string|max:50',

            // Datos fiscales
            'nombre_fiscal'       => 'nullable|string|max:255',
            'rfc'                 => 'nullable|string|max:20',
            'direccion_fiscal'    => 'nullable|string|max:255',
            'uso_cfdi'            => 'nullable|string|max:255',
            'correo'              => 'nullable|email|max:255',
            'regimen_fiscal'      => 'nullable|string|max:255',
        ], [
            'nombre_completo.required' => 'El campo Nombre completo es obligatorio.',
            'tipo_cliente.required'    => 'El campo Tipo de cliente es obligatorio.',
            'status.required'          => 'El campo Estatus es obligatorio.',
        ]);

        $cliente->update([
            'nombre_completo' => $validated['nombre_completo'],
            'empresa'         => $validated['empresa'] ?? null,
            'contacto'        => $validated['contacto'] ?? null,
            'direccion'       => $validated['direccion'] ?? null,
            'tipo_cliente'    => $validated['tipo_cliente'],
            'status'          => $validated['status'],
        ]);

        // Actualiza o crea datos fiscales
        if (
            $request->filled('rfc') ||
            $request->filled('nombre_fiscal') ||
            $request->filled('direccion_fiscal') ||
            $request->filled('uso_cfdi') ||
            $request->filled('correo') ||
            $request->filled('regimen_fiscal')
        ) {
            $cliente->datoFiscal()->updateOrCreate(
                [],
                [
                    'nombre_fiscal'    => $validated['nombre_fiscal'] ?? $validated['nombre_completo'],
                    'rfc'              => $validated['rfc'] ?? null,
                    'direccion_fiscal' => $validated['direccion_fiscal'] ?? null,
                    'uso_cfdi'         => $validated['uso_cfdi'] ?? null,
                    'correo'           => $validated['correo'] ?? null,
                    'regimen_fiscal'   => $validated['regimen_fiscal'] ?? null,
                ]
            );
        }

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente');
    }

    // Eliminar cliente
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente');
    }

    // Exportar Excel
    public function exportExcel(Request $request)
    {
        return Excel::download(new ClientesExport, 'clientes.xlsx');
    }

    // Exportar PDF
    public function exportPDF(Request $request)
    {
        $clientes = Cliente::with('datoFiscal')->get();
        $pdf = PDF::loadView('clientes.export_pdf', compact('clientes'));
        return $pdf->download('clientes.pdf');
    }
}
