<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentoCredito;
use App\Models\Credito;
use Illuminate\Support\Facades\Storage;

class DocumentoCreditoController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'credito_id'     => 'required|exists:creditos,id',
            'tipo_documento' => 'required|string|max:50',
            'archivo'        => 'required|file|mimes:pdf,jpg,jpeg,png,pdf,doc,docx,xml',
        ]);

        $credito = Credito::findOrFail($data['credito_id']);

        // Guarda archivo en storage/app/public/documentos_credito/
        $archivo_path = $request->file('archivo')->store('documentos_credito', 'public');

        $documento = DocumentoCredito::create([
            'credito_id'     => $credito->id,
            'tipo_documento' => $data['tipo_documento'],
            'archivo'        => $archivo_path,
            'fecha_subida'   => now(),
        ]);

        return redirect()->route('creditos.show', $credito)
            ->with('success', 'Documento subido correctamente.');
    }

    public function destroy(DocumentoCredito $documento_credito)
    {
        $credito_id = $documento_credito->credito_id;
        // Borra archivo físico
        if ($documento_credito->archivo && Storage::disk('public')->exists($documento_credito->archivo)) {
            Storage::disk('public')->delete($documento_credito->archivo);
        }
        $documento_credito->delete();
        return redirect()->route('creditos.show', $credito_id)
            ->with('success', 'Documento eliminado.');
    }
}
