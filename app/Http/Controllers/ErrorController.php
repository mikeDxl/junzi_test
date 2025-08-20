<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    /**
     * Maneja errores 404 (Página no encontrada)
     */
    public function notFound(Request $request)
    {
        // Log del error para debugging
        // Log::warning('404 Error: Página no encontrada', [
        //     'url' => $request->fullUrl(),
        //     'method' => $request->method(),
        //     'ip' => $request->ip(),
        //     'user_agent' => $request->userAgent(),
        //     'referer' => $request->header('referer'),
        //     'timestamp' => now()
        // ]);

        return response()->view('errors.404', [
            'requested_url' => $request->fullUrl(),
            'message' => 'La página que buscas no existe o ha sido movida.'
        ], 404);
    }

    /**
     * Maneja errores 500 (Error interno del servidor)
     */
    public function serverError(Request $request, $exception = null)
    {
        // Log del error crítico
        // Log::error('500 Error: Error interno del servidor', [
        //     'url' => $request->fullUrl(),
        //     'method' => $request->method(),
        //     'ip' => $request->ip(),
        //     'exception' => $exception ? $exception->getMessage() : 'No exception provided',
        //     'timestamp' => now()
        // ]);

        return response()->view('errors.500', [
            'message' => 'Algo salió mal en nuestro servidor. Por favor, intenta de nuevo más tarde.'
        ], 500);
    }

    /**
     * Maneja errores 403 (Acceso denegado)
     */
    public function forbidden(Request $request)
    {
        // Log::warning('403 Error: Acceso denegado', [
        //     'url' => $request->fullUrl(),
        //     'method' => $request->method(),
        //     'ip' => $request->ip(),
        //     'user_id' => auth()->id(),
        //     'timestamp' => now()
        // ]);

        return response()->view('errors.403', [
            'message' => 'No tienes permisos para acceder a esta página.'
        ], 403);
    }

    /**
     * Maneja errores 419 (Token CSRF expirado)
     */
    public function tokenMismatch(Request $request)
    {
        // Log::warning('419 Error: Token CSRF expirado', [
        //     'url' => $request->fullUrl(),
        //     'method' => $request->method(),
        //     'ip' => $request->ip(),
        //     'timestamp' => now()
        // ]);

        return response()->view('errors.419', [
            'message' => 'Tu sesión ha expirado. Por favor, recarga la página e intenta de nuevo.'
        ], 419);
    }

    /**
     * Maneja errores 429 (Demasiadas peticiones)
     */
    public function tooManyRequests(Request $request)
    {
        // Log::warning('429 Error: Demasiadas peticiones', [
        //     'url' => $request->fullUrl(),
        //     'method' => $request->method(),
        //     'ip' => $request->ip(),
        //     'timestamp' => now()
        // ]);

        return response()->view('errors.429', [
            'message' => 'Demasiadas peticiones. Por favor, espera un momento antes de intentar de nuevo.'
        ], 429);
    }

    /**
     * Maneja errores genéricos
     */
    public function genericError(Request $request, $statusCode = 500, $message = null)
    {
        $defaultMessages = [
            400 => 'Solicitud incorrecta',
            401 => 'No autorizado',
            403 => 'Acceso denegado',
            404 => 'Página no encontrada',
            405 => 'Método no permitido',
            419 => 'Token CSRF expirado',
            429 => 'Demasiadas peticiones',
            500 => 'Error interno del servidor',
            503 => 'Servicio no disponible'
        ];

        $errorMessage = $message ?? $defaultMessages[$statusCode] ?? 'Ha ocurrido un error';

        // Log::error("Error {$statusCode}: {$errorMessage}", [
        //     'url' => $request->fullUrl(),
        //     'method' => $request->method(),
        //     'ip' => $request->ip(),
        //     'timestamp' => now()
        // ]);

        // Buscar vista específica para el error o usar genérica
        $viewName = view()->exists("errors.{$statusCode}") ? "errors.{$statusCode}" : 'errors.error';

        return response()->view($viewName, [
            'statusCode' => $statusCode,
            'message' => $errorMessage,
            'requested_url' => $request->fullUrl()
        ], $statusCode);
    }
}