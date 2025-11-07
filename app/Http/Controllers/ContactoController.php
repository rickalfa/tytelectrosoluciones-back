<?php

namespace App\Http\Controllers;



use App\Models\Contacto; // Importamos el Modelo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Para validar los datos
use Illuminate\Support\Facades\Mail;      // Para enviar correos
use Illuminate\Support\Str;              // Para generar el token
use App\Mail\NotificationAdmin;          // El Mailable para ti
use App\Mail\RespuestaCliente;           // El Mailable para el cliente
use Carbon\Carbon;



class ContactoController extends Controller
{
    

    public function store(Request $request)
    {
        // --- 1. Validación (Tu "Opción A") ---
        // Validamos que los datos que llegan del frontend sean correctos.
        $validator = Validator::make($request->all(), [
            'nombre'  => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'telefono'=> 'nullable|string|max:50', // Telefono es opcional
            'mensaje' => 'required|string|min:10', // Mensaje con mínimo 10 caracteres
        ]);

        // Si la validación falla, devolvemos un error 422 al frontend
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // --- 2. Creación del Registro ---
            // Generamos un token único para la verificación
            $token = Str::uuid(); // Genera un token largo y único (ej: "a1b2c3d4-...")

            // Creamos el contacto en la base de datos
            $contacto = Contacto::create([
                'nombre'  => $request->nombre,
                'email'   => $request->email,
                'telefono'=> $request->telefono,
                'mensaje' => $request->mensaje,
                'verification_token' => $token, // Guardamos el token
            ]);

            // --- 3. Envío de Correos ---
            
            // 3.1: Enviar correo de auto-respuesta al CLIENTE (con el enlace de verificación)
            // Usaremos el Mailable 'RespuestaCliente'
            Mail::to($contacto->email)->send(new RespuestaCliente($contacto));

            // 3.2: Enviar correo de notificación al ADMIN (a ti)
            // Usaremos el Mailable 'NotificationAdmin'
            
            // !! IMPORTANTE !! Cambia esta dirección por tu correo real
            $adminEmail = 'contacto@tytelectrosoluciones.com'; 
            
           // Mail::to($adminEmail)->send(new NotificationAdmin($contacto));

            // --- 4. Respuesta al Frontend ---
            // Devolvemos una respuesta exitosa
            return response()->json([
                'status' => 'success',
                'message' => '¡Mensaje recibido! Te hemos enviado un correo de confirmación.'
            ], 201); // 201 = "Created"

        } catch (\Exception $e) {
            // Si algo sale mal (ej. la base de datos falla), capturamos el error
            // y devolvemos un error 500 al frontend.
            \Log::error('Error al guardar contacto: ' . $e->getMessage()); // Guarda el error para ti
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error interno del servidor. Por favor, inténtalo más tarde. Detail :'. $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verifica el email del usuario usando el token.
     * Esta es la lógica para la ruta: GET /api/verificar-email/{token}
     */
    public function verify($token)
    {
        // --- 1. Buscar el Contacto ---
        // Buscamos en la base de datos un contacto que tenga ese token
        $contacto = Contacto::where('verification_token', $token)->first();

        // --- 2. Validar el Token ---
        // Si no se encuentra (token inválido o ya usado)
        if (!$contacto) {
            // Damos un mensaje genérico por seguridad
            return response()->json(['message' => 'Enlace de verificación no válido.'], 404);
        }

        // Si el email ya estaba verificado (ya tiene una fecha)
        if ($contacto->email_verified_at) {
            return response()->json(['message' => 'Este correo ya ha sido verificado.'], 200);
        }

        // --- 3. Actualizar el Registro ---
        // ¡El token es válido y el email no estaba verificado!
        $contacto->email_verified_at = Carbon::now(); // Marcamos la fecha de verificación
        $contacto->verification_token = null; // Borramos el token por seguridad
        $contacto->save(); // Guardamos los cambios

        // --- 4. Respuesta ---
        // Idealmente, aquí redirigirías a una página de "Gracias" en tu frontend de Vite
        // Por ahora, devolvemos un JSON de éxito.
        return response()->json([
            'status' => 'success',
            'message' => '¡Correo verificado con éxito! Gracias.'
        ], 200);
    }
}
