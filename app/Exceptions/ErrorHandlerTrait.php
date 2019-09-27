<?php

namespace App\Exceptions;

/**
 * Trait ErrorHandlerTrait
 * @package App\Exceptions
 */
trait ErrorHandlerTrait
{
    /**
     * @param int $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(int $code, string $message)
    {
        return response()->json([
            'errors' => [
                'status_code' => $code,
                'message'     => $message,
            ]], $code);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function notfound()
    {
        return $this->response(404, 'Not found.');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function methodNotAllowed()
    {
        return $this->response(405, 'Method not allowed.');
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function permissionDoseNotExists($message)
    {
        return $this->response(500, $message);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function serverError($message)
    {
        return $this->response(500, $message);
    }
}