<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
 
class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Validar la solicitud
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed', // Validación de confirmación de contraseña
                // 'password' => [
                //     'required',
                //     'string',
                //     'min:8',             // Mínimo de 8 caracteres
                //     'confirmed',         // Confirmación de contraseña
                //     'regex:/[a-z]/',     // Al menos una letra minúscula
                //     'regex:/[A-Z]/',     // Al menos una letra mayúscula
                //     'regex:/[0-9]/',     // Al menos un número
                //     'regex:/[@$!%*?&]/', // Al menos un carácter especial
                // ],
                'has_role' => 'sometimes|in:Administrador,Colaborador,Beneficiario' // El rol es opcional y debe coincidir con los valores permitidos
            ]);

            // Crear el nuevo usuario
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']), // Usar Hash::make para la contraseña
                'has_role' => $validated['has_role'] ?? 'Beneficiario' // Asignar 'Beneficiario' si no se envía un rol
            ]);

            // Crear el token de autenticación
            $token = $user->createToken('auth_token')->plainTextToken;

            // Responder con el token y la información del usuario
            return response()->json([
                'message' => 'Usuario registrado correctamente.',
                'token' => $token,
                'user' => $user,
            ], 201);

        } catch (ValidationException $e) {
            // Manejar errores de validación
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Manejar cualquier otro error
            return response()->json(['message' => 'No se pudo registrar el usuario.'], 500);
        }
    }

    public function login(Request $request)
    {
        
        // Validar los datos de entrada
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Buscar el usuario por email
        $user = User::where('email', $request->email)->first();

        // Verificar si el usuario existe y si la contraseña es correcta
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciales incorrectas.',
            ], 401);
        }

        // Crear el token de autenticación
        $token = $user->createToken('auth_token')->plainTextToken;

        // Responder con el token y la información del usuario
        return response()->json([
            'message' => 'El usuario se ha logueado correctamente.',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Ha cerrado sesión Correctamente']);
    }

    public function userProfile(Request $request)
    {
        return response()->json($request->user());
    }
}
