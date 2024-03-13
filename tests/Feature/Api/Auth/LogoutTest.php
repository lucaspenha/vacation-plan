<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;

it('should be able to logout', function () {

    $user = User::factory()->create();

    $token = $user->createToken('auth')->plainTextToken;

    $this
        ->withHeader('Authorization', "Bearer $token")
        ->postJson(route('api.auth.logout'))
        ->assertStatus(Response::HTTP_OK);

});
