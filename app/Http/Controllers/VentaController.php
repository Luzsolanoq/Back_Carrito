<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function store(Request $request)
    {
        // Validación de los datos
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,cliente_id', // Valida que el cliente_id esté presente y sea un ID válido de cliente
            'total' => 'required|numeric', // Valida que el total sea numérico
            'productos' => 'required|array', // Valida que productos sea un arreglo
            'productos.*.idproducto' => 'required|exists:productos,idproducto', // Valida que el ID del producto exista en la tabla productos
            'productos.*.descripcion' => 'required|string', // Valida que la descripción del producto sea una cadena
            'productos.*.precio' => 'required|numeric', // Valida que el precio sea numérico
            'productos.*.cantidad' => 'required|integer|min:1', // Valida que la cantidad sea un número entero mayor o igual a 1
        ]);

        // Crear la venta
        $venta = Venta::create([
            'cliente_id' => $request->cliente_id,
            'total' => $request->total,
        ]);

        // Crear los detalles de la venta
        foreach ($request->productos as $producto) {
            DetalleVenta::create([
                'venta_id' => $venta->venta_id,
                'idproducto' => $producto['idproducto'],
                'descripcion' => $producto['descripcion'],
                'precio' => $producto['precio'],
                'cantidad' => $producto['cantidad'],
            ]);
        }

        // Responder con un mensaje de éxito
        return response()->json(['message' => 'Venta registrada correctamente'], 201);
    }
}
