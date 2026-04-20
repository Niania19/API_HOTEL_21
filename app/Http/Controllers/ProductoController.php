<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        return response()->json(Producto::all(), 200);
    }

  public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'precio' => 'required|numeric',
        'stock'  => 'required|integer',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $data = $request->only(['nombre', 'precio', 'stock']);

    if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
        $imagenPath = $request->file('imagen')->store('productos', 'public');
        $data['imagen'] = $imagenPath;
    }

    $producto = Producto::create($data);

    return response()->json([
        'mensaje' => 'Producto creado correctamente',
        'data' => $producto
    ], 201);
}



    public function show($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto, 200);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        $request->validate([

            'nombre' => 'sometimes|required|string|max:255',
            'precio' => 'sometimes|required|numeric',
            'stock'  => 'sometimes|required|integer',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['nombre', 'precio', 'stock']);

        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            // Eliminar imagen anterior si existe
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $imagenPath = $request->file('imagen')->store('productos', 'public');
            $data['imagen'] = $imagenPath;
        }

        $producto->update($data);

        return response()->json([
            'mensaje' => 'Producto actualizado correctamente',
            'data' => $producto
        ], 200);
    }

    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        // Eliminar imagen si existe
        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return response()->json([
            'mensaje' => 'Producto eliminado correctamente'
        ], 200);
    }

    // Depuración adicional
    public function debugFile(Request $request)
    {
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            return response()->json([
                'hasFile' => true,
                'isValid' => $file->isValid(),
                'originalName' => $file->getClientOriginalName(),
                'mimeType' => $file->getMimeType(),
                'size' => $file->getSize()
            ]);
        } else {
            return response()->json([
                'hasFile' => false,
                'all' => $request->all(),
                'files' => $request->files->all()
            ]);
        }
    }
}