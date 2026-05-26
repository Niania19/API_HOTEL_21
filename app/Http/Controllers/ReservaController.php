<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;

class ReservaController extends Controller
{
    // ADMIN: Listar todos los pedidos
    public function index()
    {
        $reservas = Reserva::with(['cliente', 'habitacion'])->get();
        return response()->json($reservas, 200);
    }

    // ADMIN: Ver detalle de un pedido por id
public function show($id)
{
    // 1. Buscamos la reserva por su ID de forma simple
    $reserva = Reserva::find($id);

    // 2. Si no existe, devolvemos 404 de inmediato
    if (!$reserva) {
        return response()->json(['mensaje' => 'Reserva no encontrada'], 404);
    }

    // 3. Cargamos los datos del cliente y habitación manualmente
    // Esto es mucho más seguro que usar ->with() si hay problemas de memoria
    $cliente = $reserva->cliente;
    $habitacion = $reserva->habitacion;

    // 4. Devolvemos un array manual (esto nunca debería cerrar el servidor)
    return response()->json([
        'id_reserva'    => $reserva->id_reserva,
        'id_cliente'    => $reserva->id_cliente,
        'id_habitacion' => $reserva->id_habitacion,
        'fecha_inicio'  => $reserva->fecha_inicio,
        'fecha_fin'     => $reserva->fecha_fin,
        'estado'        => $reserva->estado,
        'cliente'       => $cliente ? [
            'id_cliente' => $cliente->id_cliente,
            'nombre'     => $cliente->nombre,
            'apellido'   => $cliente->apellido,
            'correo'     => $cliente->correo
        ] : null,
        'habitacion'    => $habitacion ? [
            'id_habitacion' => $habitacion->id_habitacion,
            'numero'        => $habitacion->numero,
            'precio'        => $habitacion->precio
        ] : null
    ], 200);
}
    // ADMIN: Cancelar pedido por id
    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->estado = 'cancelado';
        $reserva->save();

        return response()->json([
            'mensaje' => 'Pedido cancelado correctamente'
        ], 200);
    }

    // ADMIN: Ver historial de pedidos de un cliente
    public function pedidosPorCliente($id_cliente)
    {
        $reservas = Reserva::where('id_cliente', $id_cliente)
            ->with('habitacion')
            ->get();

        return response()->json($reservas, 200);
    }

    // ADMIN: Ver detalle de pedido de un cliente
    public function pedidoDetalleCliente($id_cliente, $id_reserva)
    {
        $reserva = Reserva::where('id_cliente', $id_cliente)
            ->where('id_reserva', $id_reserva)
            ->with('habitacion')
            ->firstOrFail();

        return response()->json($reserva, 200);
    }
}