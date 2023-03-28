<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password], $request->remember_me)) {
            // $request->session()->regenerate();

            $token = $request->user()->createToken('login-token');
            return ['user' => new UserResource($request->user()), 'token' => $token->plainTextToken];
        }

        return response()->json(['error' => 'Credential does not match'], 401);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {    
        return $request->user()->currentAccessToken()->delete();;
    }
}
