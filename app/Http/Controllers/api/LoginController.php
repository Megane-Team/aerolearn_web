<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

// class LoginController extends Controller
// {
//     public function login(Request $request): JsonResponse
//     {
//         if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
//             $user = Auth::user();
//             $success['token'] =  $user->createToken('MyApp')->plainTextToken;
                
//             $response = [
//                 'statusCode' => 200,
//                 'message' => "Login Success",
//                 'token' => $success['token'],
//                 'user_role' => $user->user_role
//             ];
//             return response()->json($response, 200);
//         } else {
//             $response = [
//                 'statusCode' => 401,
//                 'message' => "Unauthorized",
//             ];
//             return response()->json($response, 401); 
//         }
//     }
// }

class LoginController extends Controller { public function login(Request $request): JsonResponse { 
    Log::info('Memulai proses login');
    $request->validate([ 'email' => 'required|email', 'password' => 'required', ]);
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) { 
        Log::info('Validasi input berhasil');
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post('http://192.168.225.245:3000/user/login', [ 
            'email' => $request->email, 
            'password' => $request->password, 
        ]); 

        Log::info('Permintaan HTTP dikirim', ['response' => $response->json()]);
        if ($response->successful()) {
            Log::info('Autentikasi berhasil');
            $data = $response->json(); 
            $response = [
                'statusCode' => 200,
                'message' => "Login Success",
                'token' => $data['token'],
                'user_role' => $data['user_role']
            ];
            Log::info('Login berhasil', ['response' => $response]);
            return response()->json($response, 200);
         } else { 
            Log::warning('Permintaan HTTP gagal', ['status' => $response->status()]);
                return response()->json([ 
                    'statusCode' => 401, 
                    'message' => "Unauthorized", 
                ], 401); 
            } 
        } 
        else { 
            Log::warning('Autentikasi gagal');
            return response()->json([ 'statusCode' => 401, 'message' => "Unauthorized", ], 401); 
        } 
    } 
}