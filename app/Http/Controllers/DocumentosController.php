<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\DocumentoRequerido;
use Illuminate\Support\Facades\Log;

class DocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function upload(Request $request)
    {
        try {
            // Validar los datos
            $validated = $request->validate([
                'archivo' => 'required|file|max:5120', // 5MB máximo
                'document_id' => 'required|integer|exists:documento_requeridos,id',
                'llc_id' => 'required|integer|exists:llc,id', // Cambiado de llcs a llc
            ]);

            // Obtener el documento
            $documento = DocumentoRequerido::find($validated['document_id']);
            if (!$documento) {
                return response()->json([
                    'success' => false,
                    'message' => 'Documento no encontrado'
                ], 404);
            }

            // Guardar el archivo
            $path = $request->archivo->store('documentos', 'public');
            
            // Actualizar el documento en la base de datos
            $documento->update([
                'archivo' => $path,
                'estado' => 'subido'
            ]);

            // Devolver la respuesta exitosa
            return response()->json([
                'success' => true,
                'message' => 'Archivo subido exitosamente',
                'url' => Storage::url($path),
                'documento' => [
                    'id' => $documento->id,
                    'nombre' => $documento->nombre,
                    'estado' => $documento->estado,
                    'archivo_url' => Storage::url($path)
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Manejar errores de validación
            Log::error('Error de validación en subida de archivo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error de validación: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            // Manejar otros errores
            Log::error('Error al subir archivo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el archivo: ' . $e->getMessage(),
                'error_type' => get_class($e)
            ], 500);
        }
    }

    public function revertir(Request $request)
    {
        try {
            $validated = $request->validate([
                'document_id' => 'required|integer|exists:documento_requeridos,id',
            ]);

            $documento = DocumentoRequerido::find($validated['document_id']);
            if (!$documento) {
                return response()->json([
                    'success' => false,
                    'message' => 'Documento no encontrado'
                ], 404);
            }

            // Eliminar el archivo si existe
            if ($documento->archivo) {
                Storage::disk('public')->delete($documento->archivo);
            }

            // Actualizar el estado del documento
            $documento->update([
                'archivo' => null,
                'estado' => 'pendiente'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Documento revertido exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al revertir documento: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al revertir el documento: ' . $e->getMessage(),
                'error_type' => get_class($e)
            ], 500);
        }
    }
}
