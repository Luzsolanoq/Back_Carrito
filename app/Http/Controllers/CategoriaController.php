<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Exception;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    // Listar todas las categorías activas (estado = 1)
    public function index()
    {
        $listaCategorias = Categoria::where('estado', '=', '1')->get();
        return response()->json($listaCategorias);
    }

    // Crear una nueva categoría
    public function store(Request $request)
    {
        try {
            $request->validate([
                'descripcion' => 'required|string|max:255',
            ]);

            $categoria = new Categoria();
            $categoria->descripcion = $request->descripcion;
            $categoria->estado = 1; // Por defecto, al crear, la categoría está activa
            $categoria->save();

            return response()->json([
                'idcategoria' => $categoria->idcategoria,
                'descripcion' => $categoria->descripcion,
                'created' => true
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Mostrar una categoría específica por ID
    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);
        return response()->json($categoria);
    }

    // Actualizar una categoría existente
    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);

        // Validar los datos de entrada
        $request->validate([
            'descripcion' => 'sometimes|required|string|max:255',
            'estado' => 'sometimes|required|boolean'
        ]);

        // Actualizar solo los campos proporcionados
        if ($request->has('descripcion')) {
            $categoria->descripcion = $request->descripcion;
        }
        if ($request->has('estado')) {
            $categoria->estado = $request->estado;
        }

        $categoria->save();

        return response()->json([
            'idcategoria' => $categoria->idcategoria,
            'descripcion' => $categoria->descripcion,
            'estado' => $categoria->estado,
            'updated' => true
        ]);
    }

    // Desactivar una categoría (cambiar estado a 0)
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->estado = 0;
        $categoria->save();

        return response()->json([
            'idcategoria' => $categoria->idcategoria,
            'descripcion' => $categoria->descripcion,
            'estado' => $categoria->estado,
            'deleted' => true
        ]);
    }
}
