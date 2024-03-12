<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request){

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('email','password');

        if(!auth()->attempt($credentials))
            return $this->responseWithError(
                'Invalid Credentials',[], Response::HTTP_UNAUTHORIZED
            );
        
        $token = auth()->user()->createToken('auth');

        return $this->responseWithSuccess('Login was succesfully',[
            'token' => $token->plainTextToken
        ]);

    }

    public function logout(){
        if(!auth()->user()->currentAccessToken()->delete())
            return $this->responseWithError('Could not logout');

        return $this->responseWithSuccess('Logout was succesfully');

    }
}
