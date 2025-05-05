<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\DocumentoRequerido;

class DocumentosDownloadController extends Controller
{
    public function download(Request $request, $id)
    {
        $documento = DocumentoRequerido::findOrFail($id);
        
        if (!$documento->archivo) {
            return response()->json(['error' => 'No hay archivo para descargar'], 404);
        }

        $path = Storage::disk('public')->path($documento->archivo);
        
        return response()->streamDownload(
            fn () => readfile($path),
            $documento->archivo,
            [
                'Content-Type' => Storage::disk('public')->mimeType($documento->archivo),
            ]
        );
    }
}
