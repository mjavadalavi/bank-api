<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;


class AuthController extends Controller
{
    public function register( Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = User::create($data);
        $token = $user->createToken('user-api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($data)) {
            $user = Auth::user();
            $token = $user->createToken('user-api-token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => $user,
            ]);
        }

        return response()->json([
            'error' => 'Invalid credentials'
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function refreshToken(Request $request)
    {
        $token = $request->user()->createToken('user-api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => auth()->user()
        ]);
    }
}
