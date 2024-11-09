<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        return response()->json([
            'success' => true,
        ]);
    }

    // Endpoint para el login de usuario
    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');


        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'errors' => ['email' => ['Credenciales no válidas']],
            ], 401);
        }


        $token = Auth::user()->createToken('authToken')->plainTextToken;

        // Trama de salida con el token de autenticación
        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }


    public function getUserDetails(Request $request)
    {

        $user = $request->user();

        return response()->json([
            "success" => true,

            "errors" => [
                "code" => null,
                "msg" => null
            ],

            "data" => [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "email_verified_at" => $user->email_verified_at,
                "created_at" => $user->created_at,
                "updated_at" => $user->updated_at,
            ],

            "msg" => "Detalles del usuario obtenidos correctamente",

            "count" => 1
        ]);
    }
}
