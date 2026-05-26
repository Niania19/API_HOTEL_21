<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;

class ClienteAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|unique:clientes,correo',
            'telefono' => 'required|string|max:50',
            'pais' => 'required|string|max:100',
            'password' => 'required|string|min:6|confirmed',
            'imagen' => 'nullable|image|max:2048'
        ]);

        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('clientes', 'public');
        }

        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'pais' => $request->pais,
            'password' => Hash::make($request->password),
            'imagen' => $imagenPath,
        ]);

        $token = $cliente->createToken('cliente_token')->plainTextToken;

        return response()->json([
            'mensaje' => 'Cliente registrado correctamente',
            'token' => $token,
            'cliente' => $cliente
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required|string'
        ]);

        $cliente = Cliente::where('correo', '=', $request->correo, 'and')->first();

        if (!$cliente || !Hash::check($request->password, $cliente->password)) {
            return response()->json(['mensaje' => 'Credenciales incorrectas'], 401);
        }

        $token = $cliente->createToken('cliente_token')->plainTextToken;

        return response()->json([
            'mensaje' => 'Login de cliente exitoso',
            'token' => $token,
            'cliente' => $cliente
        ]);
    }

    public function logout(Request $request)
    {
        $cliente = $request->user();

        if ($cliente) {
            /** @var PersonalAccessToken|null $token */
            $token = $cliente->currentAccessToken();
            if ($token instanceof PersonalAccessToken) {
                $token->delete();
            }
        }

        return response()->json(['mensaje' => 'Sesión de cliente cerrada correctamente']);
    }

    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    public function updateProfile(Request $request)
    {
        $cliente = $request->user();

        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'apellido' => 'sometimes|required|string|max:255',
            'correo' => 'sometimes|required|email|unique:clientes,correo,' . $cliente->id_cliente . ',id_cliente',
            'telefono' => 'sometimes|required|string|max:50',
            'pais' => 'sometimes|required|string|max:100',
            'imagen' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('imagen')) {
            if ($cliente->imagen) {
                Storage::disk('public')->delete($cliente->imagen);
            }
            $cliente->imagen = $request->file('imagen')->store('clientes', 'public');
        }

        $cliente->fill($request->only(['nombre', 'apellido', 'correo', 'telefono', 'pais']));
        $cliente->save();

        return response()->json(['mensaje' => 'Perfil actualizado correctamente', 'cliente' => $cliente]);
    }

    public function changePassword(Request $request)
    {
        $cliente = $request->user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $cliente->password)) {
            return response()->json(['mensaje' => 'La contraseña actual es incorrecta'], 403);
        }

        $cliente->password = Hash::make($request->new_password);
        $cliente->save();

        return response()->json(['mensaje' => 'Contraseña actualizada correctamente']);
    }
}
