<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecursosHumanosController extends Controller
{
    public function index(Request $request)
    {
        $empleados = Empleado::query()
            ->when($request->nombre, fn($q) => $q->where('nombre','like','%'.$request->nombre.'%')->orWhere('apellido','like','%'.$request->nombre.'%'))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->fecha_ingreso, fn($q) => $q->where('fecha_ingreso', $request->fecha_ingreso))
            ->when($request->puesto, fn($q) => $q->where('puesto','like','%'.$request->puesto.'%'))
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('recursos_humanos.index', compact('empleados'));
    }

    public function create()
    {
        return view('recursos_humanos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero_empleado'           => 'nullable|string|max:50|unique:empleados,numero_empleado',
            'nombre'                    => 'required|string|max:100',
            'apellido'                  => 'required|string|max:100',
            'rfc'                       => 'nullable|string|max:13',
            'curp'                      => 'nullable|string|max:18',
            'puesto'                    => 'required|string|max:100',
            'fecha_ingreso'             => 'required|date',
            'status'                    => 'required|in:Activo,Inactivo,Baja',
            'salario'                   => 'required|numeric|min:0',
            'notas'                     => 'nullable|string',
            'sucursal'                  => 'nullable|string|max:100',
            'telefono'                  => 'nullable|string|max:20',
            'correo'                    => 'nullable|email|max:150',
            'tipo_contrato'             => 'required|in:temporal,prueba,indefinido',
            'nss'                       => 'nullable|string|max:15',
            'salario_diario_fiscal'     => 'nullable|numeric|min:0',
            'salario_diario_no_fiscal'  => 'nullable|numeric|min:0',
            'salario_mensual_fiscal'    => 'nullable|numeric|min:0',
            'salario_mensual_no_fiscal' => 'nullable|numeric|min:0',
            'sexo'                      => 'nullable|in:M,F,Otro',
            'edad'                      => 'nullable|integer|min:0',
            'tipo_sangre'               => 'nullable|string|max:5',
            'fecha_nacimiento'          => 'nullable|date',
            'estado_civil'              => 'nullable|string|max:50',
            'domicilio'                 => 'nullable|string',
            'contacto_emergencia'       => 'nullable|string|max:100',
            'parentesco'                => 'nullable|string|max:50',
            'telefono_beneficiario'     => 'nullable|string|max:20',
            'cuenta_fiscal'             => 'nullable|string|max:30',
            'clabe_fiscal'              => 'nullable|string|max:18',
            'banco_fiscal'              => 'nullable|string|max:100',
            'cuenta_no_fiscal'          => 'nullable|string|max:30',
            'clabe_no_fiscal'           => 'nullable|string|max:18',
            'banco_no_fiscal'           => 'nullable|string|max:100',
            'tipo_empleado'             => 'required|in:fijo,freelance',
            'horario'                   => 'nullable|string|max:50',
            'dias_laborales'            => 'nullable|string|max:50',
            'justificantes_incapacidad' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        // Autogenerar número de empleado si está vacío
        if(empty($validated['numero_empleado'])){
            $lastId = Empleado::max('id') + 1;
            $validated['numero_empleado'] = 'EMP-' . str_pad($lastId, 5, '0', STR_PAD_LEFT);
        }

        // Subida de archivo
        if ($request->hasFile('justificantes_incapacidad')) {
            $path = $request->file('justificantes_incapacidad')->store('empleados/justificantes', 'public');
            $validated['justificantes_incapacidad'] = $path;
        }

        Empleado::create($validated);

        return redirect()->route('recursos_humanos.index')->with('success', 'Empleado registrado correctamente.');
    }

    public function show(Empleado $recursos_humano)
    {
        $empleado = $recursos_humano;
        return view('recursos_humanos.show', compact('empleado'));
    }

    public function edit(Empleado $recursos_humano)
    {
        $empleado = $recursos_humano;
        return view('recursos_humanos.edit', compact('empleado'));
    }

    public function update(Request $request, Empleado $recursos_humano)
    {
        $validated = $request->validate([
            'numero_empleado'           => 'nullable|string|max:50|unique:empleados,numero_empleado,' . $recursos_humano->id,
            'nombre'                    => 'required|string|max:100',
            'apellido'                  => 'required|string|max:100',
            'rfc'                       => 'nullable|string|max:13',
            'curp'                      => 'nullable|string|max:18',
            'puesto'                    => 'required|string|max:100',
            'fecha_ingreso'             => 'required|date',
            'status'                    => 'required|in:Activo,Inactivo,Baja',
            'salario'                   => 'required|numeric|min:0',
            'notas'                     => 'nullable|string',
            'sucursal'                  => 'nullable|string|max:100',
            'telefono'                  => 'nullable|string|max:20',
            'correo'                    => 'nullable|email|max:150',
            'tipo_contrato'             => 'required|in:temporal,prueba,indefinido',
            'nss'                       => 'nullable|string|max:15',
            'salario_diario_fiscal'     => 'nullable|numeric|min:0',
            'salario_diario_no_fiscal'  => 'nullable|numeric|min:0',
            'salario_mensual_fiscal'    => 'nullable|numeric|min:0',
            'salario_mensual_no_fiscal' => 'nullable|numeric|min:0',
            'sexo'                      => 'nullable|in:M,F,Otro',
            'edad'                      => 'nullable|integer|min:0',
            'tipo_sangre'               => 'nullable|string|max:5',
            'fecha_nacimiento'          => 'nullable|date',
            'estado_civil'              => 'nullable|string|max:50',
            'domicilio'                 => 'nullable|string',
            'contacto_emergencia'       => 'nullable|string|max:100',
            'parentesco'                => 'nullable|string|max:50',
            'telefono_beneficiario'     => 'nullable|string|max:20',
            'cuenta_fiscal'             => 'nullable|string|max:30',
            'clabe_fiscal'              => 'nullable|string|max:18',
            'banco_fiscal'              => 'nullable|string|max:100',
            'cuenta_no_fiscal'          => 'nullable|string|max:30',
            'clabe_no_fiscal'           => 'nullable|string|max:18',
            'banco_no_fiscal'           => 'nullable|string|max:100',
            'tipo_empleado'             => 'required|in:fijo,freelance',
            'horario'                   => 'nullable|string|max:50',
            'dias_laborales'            => 'nullable|string|max:50',
            'justificantes_incapacidad' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('justificantes_incapacidad')) {
            // Borra el archivo anterior
            if ($recursos_humano->justificantes_incapacidad) {
                Storage::disk('public')->delete($recursos_humano->justificantes_incapacidad);
            }
            $path = $request->file('justificantes_incapacidad')->store('empleados/justificantes', 'public');
            $validated['justificantes_incapacidad'] = $path;
        }

        $recursos_humano->update($validated);

        return redirect()->route('recursos_humanos.index')->with('success', 'Empleado actualizado correctamente.');
    }

    public function destroy(Empleado $recursos_humano)
    {
        if ($recursos_humano->justificantes_incapacidad) {
            Storage::disk('public')->delete($recursos_humano->justificantes_incapacidad);
        }

        $recursos_humano->delete();

        return redirect()->route('recursos_humanos.index')->with('success', 'Empleado eliminado correctamente.');
    }
}
