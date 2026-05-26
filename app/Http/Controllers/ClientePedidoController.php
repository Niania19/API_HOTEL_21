<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class ClientePedidoController extends Controller
{
    // Obtener al cliente autenticado de forma segura
    private function getCliente(Request $request) {
        return $request->user();
    }

    // CLIENTE: Crear pedido
    public function store(Request $request)
    {
        $cliente = $this->getCliente($request);

        $validated = $request->validate([
            'id_habitacion' => 'required|integer|exists:habitaciones,id_habitacion',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio'
        ]);

        $validated['id_cliente'] = $cliente->id_cliente;
        $validated['estado'] = 'pendiente'; // Siempre inicia como pendiente por seguridad

        $reserva = Reserva::create($validated);

        return response()->json([
            'mensaje' => 'Pedido creado exitosamente', 
            'data' => $reserva
        ], 201);
    }

    // CLIENTE: Ver historial de pedidos
    public function index(Request $request)
    {
        $cliente = $this->getCliente($request);

        $reservas = Reserva::where('id_cliente', $cliente->id_cliente)
            ->with('habitacion')
            ->get();

        return response()->json($reservas, 200);
    }

    // CLIENTE: Ver detalle de pedido
    public function show(Request $request, $id)
    {
        $cliente = $this->getCliente($request);

        $reserva = Reserva::where('id_cliente', $cliente->id_cliente)
            ->where('id_reserva', $id)
            ->with('habitacion')
            ->firstOrFail();

        return response()->json($reserva, 200);
    }

    // CLIENTE: Cancelar pedido
    public function destroy(Request $request, $id)
    {
        $cliente = $this->getCliente($request);

        $reserva = Reserva::where('id_cliente', $cliente->id_cliente)
            ->where('id_reserva', $id)
            ->firstOrFail();

        $reserva->estado = 'cancelado';
        $reserva->save();

        return response()->json([
            'mensaje' => 'Tu pedido ha sido cancelado correctamente'
        ], 200);
    }
}