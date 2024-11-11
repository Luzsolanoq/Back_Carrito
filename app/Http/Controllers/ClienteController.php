<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Exception;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Listar todos los clientes activos (estado = 1)
    public function index()
    {
        $listaClientes = Cliente::where('estado', '=', '1')->get();
        return response()->json($listaClientes);
    }

    // Crear un nuevo cliente
    public function store(Request $request)
    {
        try {
            $request->validate([
                'ruc_dni' => 'required|string|max:20',
                'nombres' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'direccion' => 'nullable|string|max:255',
            ]);

            $cliente = new Cliente();
            $cliente->ruc_dni = $request->ruc_dni;
            $cliente->nombres = $request->nombres;
            $cliente->email = $request->email;
            $cliente->direccion = $request->direccion;
            $cliente->estado = 1; // Por defecto, al crear, el cliente está activo
            $cliente->save();

            return response()->json([
                'cliente_id' => $cliente->cliente_id,
                'ruc_dni' => $cliente->ruc_dni,
                'nombres' => $cliente->nombres,
                'email' => $cliente->email,
                'direccion' => $cliente->direccion,
                'created' => true
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Mostrar un cliente específico por ID
    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        return response()->json($cliente);
    }

    // Actualizar un cliente existente
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        // Validar los datos de entrada
        $request->validate([
            'ruc_dni' => 'sometimes|required|string|max:20',
            'nombres' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255',
            'direccion' => 'sometimes|nullable|string|max:255',
            'estado' => 'sometimes|required|boolean'
        ]);

        // Actualizar solo los campos proporcionados
        if ($request->has('ruc_dni')) {
            $cliente->ruc_dni = $request->ruc_dni;
        }
        if ($request->has('nombres')) {
            $cliente->nombres = $request->nombres;
        }
        if ($request->has('email')) {
            $cliente->email = $request->email;
        }
        if ($request->has('direccion')) {
            $cliente->direccion = $request->direccion;
        }
        if ($request->has('estado')) {
            $cliente->estado = $request->estado;
        }

        $cliente->save();

        return response()->json([
            'cliente_id' => $cliente->cliente_id,
            'ruc_dni' => $cliente->ruc_dni,
            'nombres' => $cliente->nombres,
            'email' => $cliente->email,
            'direccion' => $cliente->direccion,
            'estado' => $cliente->estado,
            'updated' => true
        ]);
    }

    // Desactivar un cliente (cambiar estado a 0)
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->estado = 0;
        $cliente->save();

        return response()->json([
            'cliente_id' => $cliente->cliente_id,
            'ruc_dni' => $cliente->ruc_dni,
            'nombres' => $cliente->nombres,
            'email' => $cliente->email,
            'direccion' => $cliente->direccion,
            'estado' => $cliente->estado,
            'deleted' => true
        ]);
    }
}
