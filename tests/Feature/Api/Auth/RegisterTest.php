<?php

use Symfony\Component\HttpFoundation\Response;

it('should be able a register user', function () {
    
    $data = [
        'name' => 'Name Test',
        'email' => 'email@test.com',
        'password' => '123456',
    ];
    
    $this->postJson(
        route('api.auth.register',
        $data
    ))
    ->assertStatus(Response::HTTP_OK);

    unset($data['password']);
    
    $this->assertDatabaseHas('users',$data);

});

it('should be a valid data', function () {

    $data = [
        'name' => '',
        'email' => '',
        'password' => '',
    ];
    
    $this->postJson(
        route('api.auth.register',
        $data
    ))
    ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
    ->assertJsonValidationErrors([
        'name',
        'email',
        'password',
    ]);

});

it('should be a valid email and min length password', function () {

    $data = [
        'name' => 'name test',
        'email' => 'abscc',
        'password' => '090',
    ];
    
    $this->postJson(
        route('api.auth.register',
        $data
    ))
    ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
    ->assertJsonValidationErrors([
        'email' => __('validation.email', ['attribute' => 'email']),
        'password' => __('validation.min', ['attribute' => 'password','min' => '6']),
    ]);

});