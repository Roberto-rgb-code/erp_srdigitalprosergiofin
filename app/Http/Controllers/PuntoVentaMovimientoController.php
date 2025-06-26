<?php

namespace App\Http\Controllers;

use App\Models\PuntoVentaMovimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PuntoVentaMovimientoController extends Controller
{
    public function index()
    {
        $movimientos = PuntoVentaMovimiento::orderByDesc('fecha')->paginate(20);
        $saldo = PuntoVentaMovimiento::sum(\DB::raw("CASE WHEN tipo='entrada' THEN monto ELSE -monto END"));
        return view('punto_venta.index', compact('movimientos', 'saldo'));
    }

    public function create()
    {
        return view('punto_venta.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo'        => 'required|in:entrada,salida',
            'monto'       => 'required|numeric|min:0.01',
            'descripcion' => 'nullable|string|max:255',
            'fecha'       => 'required|date',
            'comprobante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        if ($request->hasFile('comprobante')) {
            $data['comprobante'] = $request->file('comprobante')->store('punto_venta', 'public');
        }

        // Si usas login:
        // $data['usuario_id'] = auth()->id();

        PuntoVentaMovimiento::create($data);

        return redirect()->route('punto_venta.index')->with('success', 'Movimiento registrado.');
    }

    public function show(PuntoVentaMovimiento $punto_ventum)
{
    return view('punto_venta.show', compact('punto_ventum'));
}


    public function edit(PuntoVentaMovimiento $punto_venta)
    {
        return view('punto_venta.edit', compact('punto_venta'));
    }

    public function update(Request $request, PuntoVentaMovimiento $punto_venta)
    {
        $data = $request->validate([
            'tipo'        => 'required|in:entrada,salida',
            'monto'       => 'required|numeric|min:0.01',
            'descripcion' => 'nullable|string|max:255',
            'fecha'       => 'required|date',
            'comprobante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        if ($request->hasFile('comprobante')) {
            // Borra archivo anterior si existe
            if ($punto_venta->comprobante && Storage::disk('public')->exists($punto_venta->comprobante)) {
                Storage::disk('public')->delete($punto_venta->comprobante);
            }
            $data['comprobante'] = $request->file('comprobante')->store('punto_venta', 'public');
        }

        $punto_venta->update($data);

        return redirect()->route('punto_venta.index')->with('success', 'Movimiento actualizado.');
    }

    public function destroy(PuntoVentaMovimiento $punto_venta)
    {
        if ($punto_venta->comprobante && Storage::disk('public')->exists($punto_venta->comprobante)) {
            Storage::disk('public')->delete($punto_venta->comprobante);
        }
        $punto_venta->delete();
        return redirect()->route('punto_venta.index')->with('success', 'Movimiento eliminado.');
    }
}
