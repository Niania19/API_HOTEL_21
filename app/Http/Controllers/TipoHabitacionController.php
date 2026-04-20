<?php

namespace App\Http\Controllers;

use App\Models\TipoHabitacion;
use Illuminate\Http\Request;

class TipoHabitacionController extends Controller
{
    public function index()
    {
        return response()->json(TipoHabitacion::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_tipo' => 'required|string|max:255',
            'descripcion' => 'required|string'
        ]);

        $tipo = TipoHabitacion::create($request->all());

        return response()->json(['mensaje' => 'Tipo de habitación creado correctamente', 'data' => $tipo], 201);
    }

    public function show($id)
    {
        $tipo = TipoHabitacion::find($id);

        if (!$tipo) {
            return response()->json(['mensaje' => 'Tipo de habitación no encontrado'], 404);
        }

        return response()->json($tipo, 200);
    }

    public function update(Request $request, $id)
    {
        $tipo = TipoHabitacion::find($id);

        if (!$tipo) {
            return response()->json(['mensaje' => 'Tipo de habitación no encontrado'], 404);
        }

        $tipo->update($request->all());

        return response()->json(['mensaje' => 'Tipo de habitación actualizado correctamente', 'data' => $tipo], 200);
    }

    public function destroy($id)
    {
        $tipo = TipoHabitacion::find($id);

        if (!$tipo) {
            return response()->json(['mensaje' => 'Tipo de habitación no encontrado'], 404);
        }

        $tipo->delete();

        return response()->json(['mensaje' => 'Tipo de habitación eliminado correctamente'], 200);
    }
}
