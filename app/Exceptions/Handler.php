<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\QueryException;
use Symfony\Component\Debug\Exception\FatalThrowableError;


class Handler extends ExceptionHandler
{
    use ErrorHandlerTrait;

    /**
     * A list of the exception types that should not be reported.
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->json([
                'errors' => [
                    'status_code' => 404,
                    'message'     => 'Not found',
                ]], 404);
        } elseif ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            return response()->json([
                'errors' => [
                    'status_code' => 405,
                    'message'     => 'Method not allowed',
                ]], 405);
        } elseif ($exception instanceof \Illuminate\Contracts\Validation\UnauthorizedException) {
            return response()->json([
                'errors' => [
                    'status_code' => 401,
                    'message'     => 'Unauthorized',
                ]], 401);
        } elseif ($exception instanceof \Illuminate\Validation\ValidationException) {
            return response()->json([
                'errors' => [
                    'status_code' => 422,
                    'message'     => $exception->getMessage(),
                    'fields'      => $exception->validator,
                ]], 422);
        } elseif ($exception instanceof ExpectationFailed) {
            return response()->json([
                'errors' => [
                    'status_code' => ExpectationFailed::code,
                    'message'     => ExpectationFailed::message,
                ]], ExpectationFailed::code);
        } elseif (
            $exception instanceof QueryException ||
            $exception instanceof InvalidArgumentException ||
            $exception instanceof Exception ||
            $exception instanceof FatalThrowableError
        ) {
            return response()->json([
                'errors' => [
                    'status_code' => 500,
                    'message'     => $exception->getMessage(),
                    'trace'       => $exception->getTrace(),
                ]], 500);
        }

        return parent::render($request, $exception);

    }

}
