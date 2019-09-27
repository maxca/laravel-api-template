<?php

namespace App\Services\Auth;

use App\Http\Requests\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

#use Tymon\JWTAuth\JWTAuth
#use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;

class JwtAuthentication
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        $userInfo   = User::where('email', $request->get('email'))->first();
        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials, $userInfo->toArray())) {

                return response()->json([
                    'errors' => [
                        'status_code' => 401,
                        'message'     => 'Unauthorized',
                        'description' => 'Invalid credentials'
                    ]], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                'errors' => [
                    'status_code' => 500,
                    'message'     => 'Unauthorized',
                    'description' => 'could not create token'
                ]], 500);
        }

        // all good so return the token
        return response()->json([
            'data' => [
                'token' => $token
            ],
        ]);
    }
}