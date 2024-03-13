<?php

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

it('should be able to login with email and password', function () {

    $user = User::factory()->create();
    
    $this->postJson(route('api.auth.login'),[
        'email' => $user->email,
        'password' => 'password',
    ])
    ->assertStatus(Response::HTTP_OK)
    
    ->assertJsonStructure([
        'data' => [
            'token'
        ]
    ]);

});

it('should be a required email and password', function () {

    $data = [
        'email' => '',
        'password' => '',
    ];
    
    $this->postJson(
        route('api.auth.login',
        $data
    ))
    ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
    ->assertJsonValidationErrors([
        'email' => __('validation.required', ['attribute' => 'email']),
        'password' => __('validation.required', ['attribute' => 'password']),
    ]);

});

it('should be a valid email and password', function () {

    $data = [
        'email' => 'qwer',
        'password' => '1413w',
    ];
    
    $this->postJson(
        route('api.auth.login',
        $data
    ))
    ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
    ->assertJsonValidationErrors([
        'email' => __('validation.email', ['attribute' => 'email']),
        'password' => __('validation.min', ['attribute' => 'password','min' => '6']),
    ]);

});