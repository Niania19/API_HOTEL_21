<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
    public function index()
    {
        return response()->json(Habitacion::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|integer',
            'id_hotel' => 'required|integer',
            'id_tipo' => 'required|integer',
            'precio' => 'required|numeric',
            'estado' => 'required|string|max:50'
        ]);

        $habitacion = Habitacion::create($request->all());

        return response()->json(['mensaje' => 'Habitación creada correctamente', 'data' => $habitacion], 201);
    }

    public function show($id)
    {
        $habitacion = Habitacion::find($id);

        if (!$habitacion) {
            return response()->json(['mensaje' => 'Habitación no encontrada'], 404);
        }

        return response()->json($habitacion, 200);
    }

    public function update(Request $request, $id)
    {
        $habitacion = Habitacion::find($id);

        if (!$habitacion) {
            return response()->json(['mensaje' => 'Habitación no encontrada'], 404);
        }

        $habitacion->update($request->all());

        return response()->json(['mensaje' => 'Habitación actualizada correctamente', 'data' => $habitacion], 200);
    }

    public function destroy($id)
    {
        $habitacion = Habitacion::find($id);

        if (!$habitacion) {
            return response()->json(['mensaje' => 'Habitación no encontrada'], 404);
        }

        $habitacion->delete();

        return response()->json(['mensaje' => 'Habitación eliminada correctamente'], 200);
    }
}
