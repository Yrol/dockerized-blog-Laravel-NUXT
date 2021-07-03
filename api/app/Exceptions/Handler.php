<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof InvalidSignatureException) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => ['message' => 'Invalid Signature']], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        if ($exception instanceof AuthorizationException) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => ['message' => 'You\'re not authorized to access this resource']], Response::HTTP_FORBIDDEN);
            }
        }

        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => ['message' => 'Resource not found']], Response::HTTP_NOT_FOUND);
            }
        }
        if ($exception instanceof ModelNotDefined) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => ['message' => 'No model defined']], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }


        return parent::render($request, $exception);
    }
}
