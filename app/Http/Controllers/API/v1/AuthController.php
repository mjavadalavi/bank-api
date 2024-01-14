<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;


class AuthController extends Controller
{
    public function register(UserRequest $request){

        $user = User::create($request->all());
        $token = $user->createToken('user-api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function login(LoginRequest $request)
    {

        if (Auth::attempt($request->all())) {
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
