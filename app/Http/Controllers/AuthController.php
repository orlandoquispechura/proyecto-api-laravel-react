<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        //verificar usuario si existe
        $user = User::where("email", "=", $request->email)->first();
        if (isset($user)) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken("auth_token")->plainTextToken;
                return response()->json(['mensaje' => 'Iniciaste sesión', 
                                    'access_token' => $token,
                                    'usuario' => $user ], 200);
            } else {
                return response()->json(['mensaje' => 'La contraseña es incorrecta']);
            }
        } else {
            return response()->json(['mensaje' => 'Usuario no existe!!!']);
        }
    }
    public function register(Request $request)
    {
        //validar datos
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        // guardar datos
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        //retornar 
        return response()->json(['mensaje' => 'Usuario registrado!!!'], 201);
    }
    public function miPerfil()
    {
        //obtener perfil
        $user = Auth::user();
        return response()->json($user);
    }
    public function salir()
    {
        //cerrar sesion sali del sistema
        Auth::user()->tokens()->delete();
        return response()->json(['status' => 1, 'mensaje' => 'Cerraste sesión!!!']);
    }
}
