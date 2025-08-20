<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\ErrorController;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpResponse\Response
     */
    public function render($request, Throwable $e)
    {
        // Si es una petición AJAX o API, devolver JSON
        if ($request->expectsJson()) {
            return $this->renderJsonResponse($request, $e);
        }

        $errorController = new ErrorController();

        // Manejo específico de diferentes tipos de excepciones
        switch (true) {
            case $e instanceof NotFoundHttpException:
            case $e instanceof ModelNotFoundException:
                return $errorController->notFound($request);

            case $e instanceof AccessDeniedHttpException:
                return $errorController->forbidden($request);

            case $e instanceof TokenMismatchException:
                return $errorController->tokenMismatch($request);

            case $e instanceof HttpException:
                $statusCode = $e->getStatusCode();
                switch ($statusCode) {
                    case 403:
                        return $errorController->forbidden($request);
                    case 419:
                        return $errorController->tokenMismatch($request);
                    case 429:
                        return $errorController->tooManyRequests($request);
                    case 500:
                        return $errorController->serverError($request, $e);
                    default:
                        return $errorController->genericError($request, $statusCode, $e->getMessage());
                }

            default:
                // Para otros errores, usar el handler por defecto en desarrollo
                if (config('app.debug')) {
                    return parent::render($request, $e);
                }
                
                // En producción, mostrar error genérico
                return $errorController->serverError($request, $e);
        }
    }

    /**
     * Render JSON response for API/AJAX requests
     */
    protected function renderJsonResponse($request, Throwable $e)
    {
        $statusCode = 500;
        $message = 'Ha ocurrido un error interno';

        if ($e instanceof HttpException) {
            $statusCode = $e->getStatusCode();
        } elseif ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
            $statusCode = 404;
            $message = 'Recurso no encontrado';
        } elseif ($e instanceof AccessDeniedHttpException) {
            $statusCode = 403;
            $message = 'Acceso denegado';
        } elseif ($e instanceof TokenMismatchException) {
            $statusCode = 419;
            $message = 'Token CSRF expirado';
        } elseif ($e instanceof ValidationException) {
            $statusCode = 422;
            $message = 'Datos de validación incorrectos';
        }

        $response = [
            'error' => true,
            'message' => $message,
            'status_code' => $statusCode,
        ];

        // Añadir detalles del error solo en desarrollo
        if (config('app.debug')) {
            $response['debug'] = [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ];
        }

        return response()->json($response, $statusCode);
    }
}