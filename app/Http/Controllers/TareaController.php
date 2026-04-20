<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index()
    {
        return response()->json(Tarea::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'completada' => 'required|boolean'
        ]);

        $tarea = Tarea::create($request->all());

        return response()->json([
            'mensaje' => 'Tarea creada correctamente',
            'data' => $tarea
        ], 201);
    }

    public function show($id)
    {
        $tarea = Tarea::find($id);

        if (!$tarea) {
            return response()->json(['mensaje' => 'Tarea no encontrada'], 404);
        }

        return response()->json($tarea, 200);
    }

    public function update(Request $request, $id)
    {
        $tarea = Tarea::find($id);

        if (!$tarea) {
            return response()->json(['mensaje' => 'Tarea no encontrada'], 404);
        }

        $tarea->update($request->all());

        return response()->json([
            'mensaje' => 'Tarea actualizada correctamente',
            'data' => $tarea
        ], 200);
    }

    public function destroy($id)
    {
        $tarea = Tarea::find($id);

        if (!$tarea) {
            return response()->json(['mensaje' => 'Tarea no encontrada'], 404);
        }

        $tarea->delete();

        return response()->json([
            'mensaje' => 'Tarea eliminada correctamente'
        ], 200);
    }
}