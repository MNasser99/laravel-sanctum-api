<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:products,email',
            'password' => 'required|string|confirmed' // Confirmed means you'll have to confirm your password when signing up.
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken; // 'myapptoken' could be any random string.

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string' // Confirmed means you'll have to confirm your password when signing up.
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check Password
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message' => 'Wrong Login Info'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken; // 'myapptoken' could be any random string.

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged Out'
        ];
    }
}
