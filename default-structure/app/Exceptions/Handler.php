<?php

namespace App\Exceptions;

use App\Http\ResponseTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable               $exception
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function render($request, Throwable $exception)
    {
        $exceptionInstance = get_class($exception);

        switch ($exceptionInstance) {
            case AuthenticationException::class:
                $status = Response::HTTP_UNAUTHORIZED;
                $message = $exception->getMessage();
                break;
            case AuthorizationException::class:
                $status = Response::HTTP_FORBIDDEN;
                $message = !empty($exception->getMessage()) ? $exception->getMessage() : 'Forbidden';
                break;
            case LockedException::class:
                $status = Response::HTTP_LOCKED;
                $message = $exception->getMessage();
                break;
            case MethodNotAllowedHttpException::class:
                $status = Response::HTTP_METHOD_NOT_ALLOWED;
                $message = 'Method not allowed';
                break;
            case NotFoundHttpException::class:
            case ModelNotFoundException::class:
                $status = Response::HTTP_NOT_FOUND;
                $message = 'The requested resource was not found';
                break;
            case MaintenanceModeException::class:
                $status = Response::HTTP_SERVICE_UNAVAILABLE;
                $message = 'The API is down for maintenance';
                break;
            case QueryException::class:
                $status = Response::HTTP_BAD_REQUEST;
                $message = 'Internal error';
                break;
            case ThrottleRequestsException::class:
                $status = Response::HTTP_TOO_MANY_REQUESTS;
                $message = 'Too many Requests';
                break;
            default:
                $status = $exception->getCode();
                $message = $exception->getMessage();
                break;
        }

        if (!empty($status) && !empty($message)) {
            return $this->respondWithCustomData(['message' => $message], $status);
        }

        return parent::render($request, $exception);
    }
}
