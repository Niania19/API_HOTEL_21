<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        return response()->json(Pago::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_reserva' => 'required|integer',
            'monto' => 'required|numeric',
            'fecha_pago' => 'required|date',
            'metodo' => 'required|string|max:100'
        ]);

        $pago = Pago::create($request->all());

        return response()->json(['mensaje' => 'Pago creado correctamente', 'data' => $pago], 201);
    }

    public function show($id)
    {
        $pago = Pago::find($id);

        if (!$pago) {
            return response()->json(['mensaje' => 'Pago no encontrado'], 404);
        }

        return response()->json($pago, 200);
    }

    public function update(Request $request, $id)
    {
        $pago = Pago::find($id);

        if (!$pago) {
            return response()->json(['mensaje' => 'Pago no encontrado'], 404);
        }

        $pago->update($request->all());

        return response()->json(['mensaje' => 'Pago actualizado correctamente', 'data' => $pago], 200);
    }

    public function destroy($id)
    {
        $pago = Pago::find($id);

        if (!$pago) {
            return response()->json(['mensaje' => 'Pago no encontrado'], 404);
        }

        $pago->delete();

        return response()->json(['mensaje' => 'Pago eliminado correctamente'], 200);
    }
}
