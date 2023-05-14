<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::get();
        return response()->json($usuarios, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required"
        ]);

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return response()->json(["mensaje" => "Usuario registrado"], 201);
    }

    public function show($id)
    {
        $usuario = User::find($id);
        if (!$usuario == null) {
            return response()->json($usuario, 200);
        } else {
            return response()->json(['mensaje' => "no existe usuario con el ID " . $id]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email," . $id,
            "password" => "required"
        ]);
        $usuario = User::find($id);

        if (!$usuario == null) {
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->password);
            $usuario->save();

            return response()->json(["mensaje" => "Usuario modificado"], 201);
        } else {
            return response()->json(['mensaje' => "no existe usuario con el ID " . $id]);
        }
    }
    public function destroy($id)
    {
        $usuario = User::find($id);
        if (!$usuario == null) {
            $usuario->delete();
            return response()->json(["mensaje" => "Usuario eliminado"], 204);
        } else {
            return response()->json(['mensaje' => "no existe usuario con el ID " . $id]);
        }
    }
}
