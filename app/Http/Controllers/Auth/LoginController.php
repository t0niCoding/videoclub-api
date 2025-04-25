<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'acces_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            
            ], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function me(): JsonResource {

        $user = Auth::user();
        return new JsonResource($user);


    }
    public function logout(Request $request)
    {
      
        $user = Auth::user();
        session()->invalidate();
    
        $user->tokens->currentAccessToken(function ($token) {
            $token->delete();
        });
    
        Auth::logout();

        return response()->json(['message' => 'Logout successful'], 200);
    }
}
