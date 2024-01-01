<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

    public function login(Request $request){

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!Auth::attempt($validated)){
            return response()->json([
                'message' => 'Login information invalid.'
            ], 401);
        }

        $user = User::where('email', $validated['email'])->first();

        return response()->json([
            'access_token' => $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer',
            'data' => $user
        ], 200);
    }

    public function register(Request $request){


        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|max:255|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'is_admin' => 'int'
        ]);

        $user = User::create($validated);

        return response()->json([
            'access_token' => $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer',
            'data' => $user
        ], 201);
    }

    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'logout'
        ], 201);
    }
}
