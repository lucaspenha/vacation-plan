<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function register(Request $request, User $user){

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user_data = $request->only('name','email','password');

        if(!$user = $user->create($user_data))
            return $this->responseWithError('Sorry, could not user registered');

        return $this->responseWithSuccess('User register successful',[
            'user' => $user
        ]);

    }
}
