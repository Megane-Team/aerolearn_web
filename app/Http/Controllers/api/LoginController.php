<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;

            $response = [
                'statusCode' => 200,
                'message' => "Login Success",
                'token' => $success['token'],
                'user_role' => $user->user_role
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'statusCode' => 401,
                'message' => "Unauthorized",
            ];
            return response()->json($response, 401); 
        }
    }
}
