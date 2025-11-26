<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    //

/**
     * Maneja el proceso de inicio de sesión y devuelve el token de Sanctum.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            // 1. Validar los datos de entrada
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // 2. Intentar autenticar al usuario
            if (!Auth::attempt($request->only('email', 'password'))) {
                // Si la autenticación falla (credenciales incorrectas)
                throw ValidationException::withMessages([
                    'email' => ['Las credenciales proporcionadas son incorrectas.'],
                ]);
            }

            // 3. Obtener el usuario autenticado
            $user = $request->user();

            // 4. Crear el Token de Acceso Personal (Sanctum Bearer Token)
            // 'auth-token' es el nombre que le das al token (puedes elegir otro)
            $token = $user->createToken('auth-token')->plainTextToken;

            // 5. Devolver la respuesta JSON
            return response()->json([
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    // Puedes añadir más datos del usuario si es necesario
                ]
            ], 200);

        } catch (ValidationException $e) {
            // Manejar errores de validación de Laravel (ej. campo requerido, formato de email)
            return response()->json([
                'message' => 'Error de validación.',
                'errors' => $e->errors()
            ], 422);
        }
    }





}
