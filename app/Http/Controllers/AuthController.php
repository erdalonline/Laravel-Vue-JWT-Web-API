<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(){
        $credentials = \request (['email', 'password']);
        if (! $token = JWTAuth::attempt($credentials)) {
            return response ()->json (['error' => 'Unauthorized', 'type' => 'danger', 'message' => 'Bilgileriniz Hatalı!'], 401);
        }
        return $this->respondWithToken ($token);

    }

    public function user(){
        $user = Auth::user ();
        return response ()->json ($user);
    }

    public function logout(Request $request){
//        $this->validate ($request, [
//            'token' => 'required'
//        ]);
        JWTAuth::invalidate();
        return response ()->json ([
                'type' => 'success',
                'message' => 'çıkış yapıldı'
            ]
        );
//
    }

    protected function respondWithToken($token){
        return response ()->json ([
            'access_token' => $token,
            'type' => 'success',
            'message' => 'Giriş başarılı yönlendiriliyorsunuz.'
        ]);
    }
}
