<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit ? $request->limit : 5;
        if (isset($request->q)) {
            $productos = Producto::where("nombre", "like", "%" . $request->q . "%")
                ->with("categoria")
                ->orderBy("id", "desc")
                ->paginate($limit);
        } else {
            $productos = Producto::orderBy("id", "desc")
                ->with("categoria")
                ->paginate($limit);
        }

        return response()->json($productos, 200);
    }
    public function store(Request $request)
    {
        //validar las entradas del formulario
        $request->validate([
            "nombre" => "required",
            "categoria_id" => "required"
        ]);
        // recoger los datos del formulario y guardar
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->observacion = $request->observacion;
        $producto->categoria_id = $request->categoria_id;
        $producto->save();
        // retornar response status: 201
        return response()->json(['mensaje' => 'Producto registrado.'], 201);
    }
    public function show($id)
    {
        $producto = Producto::with('categoria')->find($id);
        if (!$producto == null) {
            return response()->json($producto, 200);
        } else {
            return response()->json(['mensaje' => 'No existe e producto con el ID ' . $id]);
        }
    }
    public function update(Request $request, $id)
    {
        //validar las entradas del formulario
        $request->validate([
            "nombre" => "required",
            "categoria_id" => "required"
        ]);
        // recoger los datos del formulario y guardar
        $producto = Producto::find($id);
        if (!$producto == null) {
            $producto->nombre = $request->nombre;
            $producto->precio = $request->precio;
            $producto->stock = $request->stock;
            $producto->observacion = $request->observacion;
            $producto->categoria_id = $request->categoria_id;
            $producto->update();
            // retornar response status: 201
            return response()->json(['mensaje' => 'Producto modificado.'], 201);
        } else {
            return response()->json(['mensaje' => 'El producto no existe con el ID ' . $id]);
        }
    }
    public function destroy($id)
    {
        $producto = Producto::find($id);
        if (!$producto == null) {
            $producto->delete();
            return response()->json(['mensaje' => 'Producto eliminado.'], 204);
        } else {
            return response()->json(['mensaje' => 'El producto no existe con el ID ' . $id]);
        }
    }
}
