<?php

namespace App\Exceptions;

use App\Http\ResponseTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\Exceptions\InvalidIncludeQuery;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $exception
     *
     * @return void
     *
     * @throws \Exception
     */
    public function report(\Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $exception
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, \Exception $exception)
    {
        $exceptionInstance = get_class($exception);

        switch ($exceptionInstance) {
            case AuthenticationException::class:
                $status = Response::HTTP_UNAUTHORIZED;
                $message = 'Unauthenticated';
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
            case QueryException::class:
                $status = Response::HTTP_BAD_REQUEST;
                $message = 'Verify query parameters';
                break;
            case AuthorizationException::class:
                $status = Response::HTTP_FORBIDDEN;
                $message = !empty($exception->getMessage()) ? $exception->getMessage() : 'Forbidden';
                break;
            case ThrottleRequestsException::class:
                $status = Response::HTTP_TOO_MANY_REQUESTS;
                $message = 'Too many attemps';
                break;
            case InvalidIncludeQuery::class:
                $status = Response::HTTP_BAD_REQUEST;
                $message = $exception->getMessage();
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
