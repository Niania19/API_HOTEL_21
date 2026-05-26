<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Producto;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'items' => 'required|array'
        ]);

        $userId = $request->user_id;
        $items = $request->items;
        $total = 0;

        foreach ($items as $item) {

            $product = Producto::find($item['product_id']);

            if (!$product) {

                return response()->json([
                    'message' => 'Producto no encontrado'
                ], 404);
            }

            $stock = (int) $product->stock;

            $quantity = (int) $item['quantity'];

            if ($stock < $quantity) {

                return response()->json([
                    'message' => 'Stock insuficiente para ' . $product->nombre
                ], 400);
            }

            $total += (float)$item['price'] * $quantity;
        }

        $order = Order::create([
            'user_id' => $userId,
            'total' => $total,
            'status' => 'pendiente'
        ]);

        foreach ($items as $item) {

            $product = Producto::find($item['product_id']);

            $product->stock -= $item['quantity'];

            $product->save();

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        return response()->json([
            'message' => 'Pedido creado correctamente',
            'order' => $order
        ], 201);
    }

    public function index($userId)
    {
        return Order::where('user_id', $userId)->get();
    }

    public function show($userId, $orderId)
    {
        $order = Order::with('items.producto')
            ->where('id', $orderId)
            ->where('user_id', $userId)
            ->first();

        if (!$order) {

            return response()->json([
                'message' => 'Pedido no encontrado'
            ], 404);
        }

        return response()->json($order);
    }

    public function cancel($userId, $orderId)
    {
        $order = Order::where('id', $orderId)
                    ->where('user_id', $userId)
                    ->firstOrFail();

        foreach ($order->items as $item) {

            $producto = Producto::find($item->product_id);

            if ($producto) {

                \Illuminate\Support\Facades\DB::table('productos')
                    ->where('id', $item->product_id)
                    ->increment('stock', $item->quantity);
            }
        }

        $order->status = 'cancelado';

        $order->save();

        return response()->json([
            'message' => 'Pedido cancelado correctamente'
        ]);
    }

    // NUEVO MÉTODO PARA PAYPAL
    public function updatePayment(Request $request, $orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {

            return response()->json([
                'message' => 'Pedido no encontrado'
            ], 404);
        }

        $order->transaction_id = $request->transaction_id;

        $order->payment_status = $request->payment_status;

        $order->payment_date = $request->payment_date;

        $order->save();

        return response()->json([
            'message' => 'Pago actualizado',
            'order' => $order
        ]);
    }
}