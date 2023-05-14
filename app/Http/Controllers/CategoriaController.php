<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with('productos')->get();
        return response()->json($categorias, 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:30',
            'observacion' => 'nullable|max:255'
        ]);

        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->observacion = $request->observacion;
        $categoria->save();
        return response()->json([
            'mensaje' => 'Se registro la categoría'
        ], 200);
    }
    public function show($id)
    {
        $categoria = Categoria::with("productos")->find($id);
        if (!$categoria == null) {
            return response()->json($categoria, 200);
        } else {
            return response()->json(['mensaje' => 'La Categoría no existe con el ID ' . $id]);
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:30',
            'observacion' => 'nullable|max:255'
        ]);
        $categoria = Categoria::find($id);

        if (!$categoria == null) {
            $categoria->nombre = $request->nombre;
            $categoria->observacion = $request->observacion;
            $categoria->update();
            return response()->json(['mensaje' => 'Se modificó la categoría'], 201);
        } else {
            return response()->json(['mensaje' => 'La Categoría no existe con el ID ' . $id]);
        }
    }
    public function destroy($id)
    {
        $categoria = Categoria::find($id);
        if (!$categoria == null) {
            $categoria->delete();
            return response()->json(['mensaje' => 'Se eliminó la categoría'], 204);
        } else {
            return response()->json(['mensaje' => 'La Categoría no existe con el ID ' . $id]);
        }
    }
}
