<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);
        $user=User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password'])
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
            'access_token' => $token,
        ],201);
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'email|required',
            'password' =>'required'
        ]);
        $user = User::where('email', $credentials['email'])->first();
        if(!$user || !bcrypt($credentials['password'])){
            return response()->json([
                'message' => 'Invalid credentials'
            ],401);
        }
        return response()->json([
            'message' => 'User logged in successfully',
            'data' => $user,
            'access_token' => $user->createToken('auth_token')->plainTextToken,
        ],200);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
           'message' => 'User logged out successfully'
        ],200);
    }
}
