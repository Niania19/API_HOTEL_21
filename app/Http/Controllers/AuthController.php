<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Model\Cliente;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'token' => $token
        ], 201);
    }

    public function login(Request $request)
{
    $cliente = Cliente::where('correo', $request->correo)->first();

    if (!$cliente || !Hash::check($request->password, $cliente->password)) {

        return response()->json([
            'message' => 'Credenciales incorrectas'
        ], 401);
    }

    $token = $cliente->createToken('cliente_token')->plainTextToken;

    return response()->json([
        'message' => 'Login exitoso',
        'token' => $token,
        'cliente' => $cliente
    ]);
}

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ]);
    }
}