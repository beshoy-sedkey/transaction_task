<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if ($request->wantsJson()) {
                $user = Auth::user();
                $token = JWTAuth::fromUser($user);
                return response()->json(['token' => $token]);
            } else {
                $user = Auth::user();
                // For web requests, use Laravel's built-in session
                auth()->login($user);
                return redirect()->intended('/');
            }
        } else {
            // Authentication failed
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function index(){
        dd('sss');
    }
}
