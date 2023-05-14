<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::orderBy('id', 'desc')->get();
        return response()->json($clientes, 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "apellidos" => "nullable",
            "ci_nit" => "required",
            "telefono" => "nullable",
            "email" => "nullable|email|unique:clientes,email"
        ]);

        $cliente = new Cliente();
        $cliente->nombre = $request->nombre;
        $cliente->apellidos = $request->apellidos;
        $cliente->ci_nit = $request->ci_nit;
        $cliente->telefono = $request->telefono;
        $cliente->email = $request->email;

        $cliente->save();

        return response()->json(["mensaje" => "Cliente registrado"], 201);
    }

    public function show($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente == null) {
            return response()->json($cliente, 200);
        } else {
            return response()->json(['mensaje' => 'El cliente no existe con el ID ' . $id]);
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            "nombre" => "required",
            "apellidos" => "nullable",
            "ci_nit" => "required",
            "telefono" => "nullable",
            "email" => "nullable|email|unique:clientes,email," . $id
        ]);

        $cliente = Cliente::find($id);

        if (!$cliente == null) {
            $cliente->nombre = $request->nombre;
            $cliente->apellidos = $request->apellidos;
            $cliente->ci_nit = $request->ci_nit;
            $cliente->telefono = $request->telefono;
            $cliente->email = $request->email;

            $cliente->update();

            return response()->json(["mensaje" => "Cliente modificado"], 201);
        } else {
            return response()->json(['mensaje' => 'El cliente no existe con el ID ' . $id]);
        }
    }
    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente == null) {
            $cliente->delete();
            return response()->json(["mensaje" => "Cliente eliminado del sistema"], 204);
        } else {
            return response()->json(['mensaje' => 'El cliente no existe con el ID ' . $id]);
        }
    }
}
