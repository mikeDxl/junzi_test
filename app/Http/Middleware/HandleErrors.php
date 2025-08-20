<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ErrorController;
use Symfony\Component\HttpFoundation\Response;

class HandleErrors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $response = $next($request);
            
            // Verificar si la respuesta es un error HTTP
            if ($response->getStatusCode() >= 400) {
                return $this->handleHttpError($request, $response);
            }
            
            return $response;
            
        } catch (\Exception $e) {
            // Log del error
            Log::error('Error capturado por middleware', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            // Si es en modo debug, lanzar la excepción para ver el error completo
            if (config('app.debug')) {
                throw $e;
            }
            
            // En producción, redirigir a página de error
            $errorController = new ErrorController();
            return $errorController->serverError($request, $e);
        }
    }
    
    /**
     * Manejar errores HTTP específicos
     */
    private function handleHttpError(Request $request, Response $response)
    {
        $statusCode = $response->getStatusCode();
        $errorController = new ErrorController();
        
        switch ($statusCode) {
            case 404:
                return $errorController->notFound($request);
            case 403:
                return $errorController->forbidden($request);
            case 419:
                return $errorController->tokenMismatch($request);
            case 429:
                return $errorController->tooManyRequests($request);
            case 500:
                return $errorController->serverError($request);
            default:
                return $response; // Devolver la respuesta original para otros códigos
        }
    }
}