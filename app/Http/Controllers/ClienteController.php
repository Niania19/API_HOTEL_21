<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;


class ClienteController extends Controller
{
    public function index()
    {
        return response()->json(Cliente::all(), 200);
    }
public function login(Request $request)
{
    $cliente = Cliente::where('correo', $request->correo)->first();

    if (!$cliente || !Hash::check($request->password, $cliente->password)) {

        return response()->json([
            'message' => 'Credenciales incorrectas'
        ], 401);
    }

    $token = $cliente->createToken('auth_token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'cliente' => $cliente
    ]);
}
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|unique:clientes,correo',
            'telefono' => 'nullable|string|max:50',
            'pais' => 'nullable|string|max:100',
            'password' => 'required|string|min:6',
            'imagen' => 'nullable|string|max:255',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $cliente = Cliente::create($validated);

        return response()->json($cliente, 201);
    }

    public function show($id)
    {
        $cliente = Cliente::find($id, ['*']);

        if (!$cliente) {
            return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
        }

        return response()->json($cliente, 200);
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id, ['*']);

        if (!$cliente) {
            return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
        }

        $validated = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'correo' => 'sometimes|email|unique:clientes,correo,' . $id . ',id_cliente',
            'telefono' => 'nullable|string|max:50',
            'pais' => 'nullable|string|max:100',
            'password' => 'sometimes|string|min:6',
            'imagen' => 'nullable|string|max:255',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $cliente->update($validated);

        return response()->json($cliente, 200);
    }
public function register(Request $request)
{
    $request->validate([
        'nombre' => 'required',
        'apellido' => 'required',
        'correo' => 'required|email|unique:clientes,correo',
        'telefono' => 'required',
        'pais' => 'required',
        'password' => 'required|min:4|confirmed'
    ]);

    $cliente = Cliente::create([
        'nombre' => $request->nombre,
        'apellido' => $request->apellido,
        'correo' => $request->correo,
        'telefono' => $request->telefono,
        'pais' => $request->pais,
        'password' => Hash::make($request->password)
    ]);

    return response()->json([
        'message' => 'Cliente registrado',
        'cliente' => $cliente
    ], 201);
}
public function profile(Request $request)
{
    return response()->json($request->user());
}
    public function destroy($id)
    {
        $cliente = Cliente::find($id, ['*']);

        if (!$cliente) {
            return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
        }

        $cliente->delete();

        return response()->json(['mensaje' => 'Cliente eliminado correctamente'], 200);
    }
}
