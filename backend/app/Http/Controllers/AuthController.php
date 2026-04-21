<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        // Eliminar tokens anteriores si quieres forzar solo uno activo:
        // $usuario->tokens()->delete();

        $token = $usuario->createToken('auth_token')->plainTextToken;

        $ip = $request->ip();
        $ciudad = 'No disponible';
        $estado = 'No disponible';
        $latitud = 'No disponible';
        $longitud = 'No disponible';

        try {
            // Evitar consultar localhost o IPs privadas si estás en desarrollo
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                $response = Http::timeout(5)->get("https://api.ipquery.io/{$ip}");

                if ($response->successful()) {
                    $data = $response->json();

                    $ciudad = $data['location']['city'] ?? 'No disponible';
                    $estado = $data['location']['state'] ?? 'No disponible';
                    $latitud = $data['location']['latitude'] ?? 'No disponible';
                    $longitud = $data['location']['longitude'] ?? 'No disponible';
                }
            }
        } catch (\Throwable $e) {
            // No romper el login si falla la API
        }

        try {
            $mensaje = "Nuevo inicio de sesión\n\n"
                . "IP: {$ip}\n"
                . "Ciudad: {$ciudad}\n"
                . "Estado: {$estado}\n"
                . "Latitud: {$latitud}\n"
                . "Longitud: {$longitud}\n"
                . "Fecha: " . now()->format('d/m/Y h:i:s A');

            Mail::raw($mensaje, function ($mail) {
                $mail->to('javssala@gmail.com')
                     ->subject('Nuevo inicio de sesión');
            });
        } catch (\Throwable $e) {
            // No romper el login si falla el correo
        }

        return response()->json([
            'message' => 'Login exitoso',
            'token' => $token,
            'usuario' => $usuario->load('rol.permisos.modulo')
        ]);
    }

    // 🚪 Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }
}
