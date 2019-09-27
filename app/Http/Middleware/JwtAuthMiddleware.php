<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Validation\UnauthorizedException;

class JwtAuthMiddleware
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if (!$user = JwtAuthMiddleware::parseToken()->authenticate()) {
                return response()->json([
                    'errors' => [
                        'status_code' => 401,
                        'message'     => 'Unauthorized',
                        'description' => 'Not found user'
                    ]], 401);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'errors' => [
                    'status_code' => 401,
                    'message'     => 'Unauthorized',
                    'description' => 'Token expired'
                ]], 401);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'errors' => [
                    'status_code' => 401,
                    'message'     => 'Unauthorized',
                    'description' => 'Invalid token'
                ]], 401);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'errors' => [
                    'status_code' => 401,
                    'message'     => 'Unauthorized',
                    'description' => 'Token not found'
                ]], 401);
        }
        config('user', $user);
        return $next($request);
    }

}
