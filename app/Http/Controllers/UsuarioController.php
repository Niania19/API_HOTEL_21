<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Reserva;

class UsuarioController extends Controller
{
    // Listar todos los usuarios
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        $usuario = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'mensaje' => 'Usuario creado correctamente',
            'data'    => $usuario
        ], 201);
    }

   public function show($id)
    {
        // dd() detiene la ejecución inmediatamente y muestra el mensaje.
        dd("¡Éxito! La petición superó el middleware y llegó al controlador. El ID es: " . $id);

        $reserva = Reserva::with(['cliente', 'habitacion'])->findOrFail($id);
        return response()->json($reserva, 200);
    }
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $usuario->update($request->except('password'));

        return response()->json([
            'mensaje' => 'Usuario actualizado correctamente',
            'data'    => $usuario
        ], 200);
    }

    
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        $usuario->delete();

        return response()->json([
            'mensaje' => 'Usuario eliminado correctamente'
        ], 200);
    }
}
