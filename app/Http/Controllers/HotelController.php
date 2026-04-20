<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    // Listar todos los hoteles
    public function index()
    {
        return response()->json(Hotel::all(), 200);
    }

    // Mostrar un hotel específico
    public function show($id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response()->json(['mensaje' => 'Hotel no encontrado'], 404);
        }

        return response()->json($hotel, 200);
    }

    // Crear un nuevo hotel
    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono'  => 'nullable|string|max:20',
            'id_ciudad' => 'required|integer'
        ]);

        $hotel = Hotel::create($request->all());

        return response()->json([
            'mensaje' => 'Hotel creado correctamente',
            'data'    => $hotel
        ], 201);
    }

    // Actualizar un hotel existente
    public function update(Request $request, $id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response()->json(['mensaje' => 'Hotel no encontrado'], 404);
        }

        $request->validate([
            'nombre'    => 'sometimes|required|string|max:255',
            'direccion' => 'sometimes|required|string|max:255',
            'telefono'  => 'nullable|string|max:20',
            'id_ciudad' => 'sometimes|required|integer'
        ]);

        $hotel->update($request->all());

        return response()->json([
            'mensaje' => 'Hotel actualizado correctamente',
            'data'    => $hotel
        ], 200);
    }

    // Eliminar un hotel
    public function destroy($id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response()->json(['mensaje' => 'Hotel no encontrado'], 404);
        }

        $hotel->delete();

        return response()->json([
            'mensaje' => 'Hotel eliminado correctamente'
        ], 200);
    }
}
