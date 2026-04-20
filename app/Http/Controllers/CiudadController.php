<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Http\Request;

class CiudadController extends Controller
{
    public function index()
    {
        return response()->json(Ciudad::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'pais' => 'required|string|max:255'
        ]);

        $ciudad = Ciudad::create($request->all());

        return response()->json(['mensaje' => 'Ciudad creada correctamente', 'data' => $ciudad], 201);
    }

    public function show($id)
    {
        $ciudad = Ciudad::find($id);

        if (!$ciudad) {
            return response()->json(['mensaje' => 'Ciudad no encontrada'], 404);
        }

        return response()->json($ciudad, 200);
    }

    public function update(Request $request, $id)
    {
        $ciudad = Ciudad::find($id);

        if (!$ciudad) {
            return response()->json(['mensaje' => 'Ciudad no encontrada'], 404);
        }

        $ciudad->update($request->all());

        return response()->json(['mensaje' => 'Ciudad actualizada correctamente', 'data' => $ciudad], 200);
    }

    public function destroy($id)
    {
        $ciudad = Ciudad::find($id);

        if (!$ciudad) {
            return response()->json(['mensaje' => 'Ciudad no encontrada'], 404);
        }

        $ciudad->delete();

        return response()->json(['mensaje' => 'Ciudad eliminada correctamente'], 200);
    }
}
