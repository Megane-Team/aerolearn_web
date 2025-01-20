<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) 
    {   

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $url = config('app.api_base_url');
            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json'
                ])->post($url.'/user/login', [
                    'email' => $request->email,
                    'password' => $request->password,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $token = $data['token'];
                    if (!session()->isStarted()) { session()->start(); } 
                    session(['api_token' => $token]);
                    $response = [
                        'statusCode' => 200,
                        'message' => "Login Success",
                        'token' => $data['token'],
                        'user_role' => $data['user_role']
                    ];
                    
                    return redirect($this->redirectTo);
                }
            } catch (\Exception $e) {
                Log::error('Terjadi kesalahan saat mengirim permintaan HTTP', ['error' => $e->getMessage()]);
                return response()->json([
                    'statusCode' => 500,
                    'message' => "Internal Server Error",
                ], 500);
            }
        } else {
            return redirect('login');
        }
    }
}

