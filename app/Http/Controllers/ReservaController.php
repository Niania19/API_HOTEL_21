<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {
        return response()->json(Reserva::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|integer',
            'id_habitacion' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|string|max:50'
        ]);

        $reserva = Reserva::create($request->all());

        return response()->json(['mensaje' => 'Reserva creada correctamente', 'data' => $reserva], 201);
    }

    public function show($id)
    {
        $reserva = Reserva::find($id);

        if (!$reserva) {
            return response()->json(['mensaje' => 'Reserva no encontrada'], 404);
        }

        return response()->json($reserva, 200);
    }

    public function update(Request $request, $id)
    {
        $reserva = Reserva::find($id);

        if (!$reserva) {
            return response()->json(['mensaje' => 'Reserva no encontrada'], 404);
        }

        $reserva->update($request->all());

        return response()->json(['mensaje' => 'Reserva actualizada correctamente', 'data' => $reserva], 200);
    }

    public function destroy($id)
    {
        $reserva = Reserva::find($id);

        if (!$reserva) {
            return response()->json(['mensaje' => 'Reserva no encontrada'], 404);
        }

        $reserva->delete();

        return response()->json(['mensaje' => 'Reserva eliminada correctamente'], 200);
    }
}
