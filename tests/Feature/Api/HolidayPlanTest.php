<?php

use App\Facades\HolidayPlanGeneratePdfFacade;
use App\Models\HolidayPlan;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

test('test if the route gets all holiday plans with no results', function () {
    
    $user = User::factory()->create();
    $this->actingAs($user)
        ->getJson(route('api.holiday-plans.index'))
        ->assertStatus(Response::HTTP_NO_CONTENT);
});

test('test if the route gets all holiday plans with results', function () {
    
    HolidayPlan::factory()->count(10)->create();
    
    $user = User::factory()->create();
    $this->actingAs($user)
        ->getJson(route('api.holiday-plans.index'))
        ->assertStatus(Response::HTTP_OK);
});

it('should be able to validate required inputs in the create route', function () {
    
    $data = [
        'title' => '',
        'description' => '',
        'date' => '',
        'location' => '',
    ];
    $user = User::factory()->create();
    $this->actingAs($user)
        ->postJson(
            route('api.holiday-plans.store'),
            $data
        )
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors([
            'title' => __('validation.required', ['attribute' => 'title']),
            'description' => __('validation.required', ['attribute' => 'description']),
            'date' => __('validation.required', ['attribute' => 'date']),
            'location' => __('validation.required', ['attribute' => 'location']),
        ]);
});

it('should be able to validate a required date format Y-m-d in the create route', function () {
    
    $data = [
        'title' => 'Test title',
        'description' => 'Test description',
        'date' => now()->format('d/m/Y'),
        'location' => 'Test location',
    ];

    $user = User::factory()->create();
    $this->actingAs($user)
        ->postJson(
            route('api.holiday-plans.store'),
            $data
        )
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors([
            'date' => __('validation.date_format', ['attribute' => 'date', 'format' => 'Y-m-d']),
        ]);
});

it('should be able to create a holiday plan in the create route', function () {
    
    $data = HolidayPlan::factory()->createOne()->toArray();
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson(
            route('api.holiday-plans.store'),
            $data
        )
        ->assertStatus(Response::HTTP_CREATED);
});

test('if holiday plan not found in the get route', function () {
    
    $user = User::factory()->create();

    $this->actingAs($user)
        ->getJson(
            route('api.holiday-plans.show',
            ['holiday_plan' => 1]
        ))
        ->assertStatus(Response::HTTP_NOT_FOUND);
});

it('should be able to return one holiday plan in the get route', function () {
    
    $data = HolidayPlan::factory()->createOne();
    $user = User::factory()->create();

    $this->actingAs($user)
        ->getJson(
            route('api.holiday-plans.show',
            ['holiday_plan' => $data->id ]
        ))
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'date',
                'location',
                'created_at',
            ]
        ]);
});

it('should be able to validate body request in the update route', function () {
    
    $data = HolidayPlan::factory()->createOne();
    $user = User::factory()->create();
    $this->actingAs($user)
        ->putJson(
            route('api.holiday-plans.update',['holiday_plan' => $data->id ])
        )
        ->assertStatus(Response::HTTP_BAD_REQUEST);
});

test('test if holiday plan not found in the update route', function () {
    
    $user = User::factory()->create();

    $this->actingAs($user)
        ->putJson(
            route('api.holiday-plans.update',['holiday_plan' => 1 ])
        )
        ->assertStatus(Response::HTTP_NOT_FOUND);
});

it('should be able to validate a required date format Y-m-d and participants in the update route', function () {
    
    $user = User::factory()->create();
    $id = HolidayPlan::factory()->createOne()->id;
    $data = [
        'date' => now()->format('d/m/Y'),
        'participants' => 'participant 1,participant 3,participant 3',
    ];

    $this->actingAs($user)
        ->putJson(
            route('api.holiday-plans.update',['holiday_plan' => $id ]),
            $data
        )
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors([
            'date' => __('validation.date_format', ['attribute' => 'date', 'format' => 'Y-m-d']),
            'participants' => __('validation.array', ['attribute' => 'participants']),
        ]);
});

it('should be able to update a holiday plan in the update route', function () {
    
    $id = HolidayPlan::factory()->createOne()->id;
    $user = User::factory()->create();
    $data = HolidayPlan::factory()->createOne()->toArray();
    
    $this->actingAs($user)
        ->putJson(
            route('api.holiday-plans.update',[ $id ]),
            $data
        )
        ->assertStatus(Response::HTTP_OK);
});

test('test if holiday plan not found in the delete route', function () {
    
    $user = User::factory()->create();

    $this->actingAs($user)
        ->deleteJson(
            route('api.holiday-plans.destroy',['holiday_plan' => 1 ])
        )
        ->assertStatus(Response::HTTP_NOT_FOUND);
});

it('should be able to desttoy a holiday plan in the delete route', function () {
    
    $id = HolidayPlan::factory()->createOne()->id;
    $user = User::factory()->create();
    
    $this->actingAs($user)
        ->deleteJson(route('api.holiday-plans.update',[ $id ]))
        ->assertStatus(Response::HTTP_NO_CONTENT);
});

test('test if holiday plan not found in the pdf generate route', function () {
    
    $user = User::factory()->create();

    $this->actingAs($user)
        ->getJson(
            route('api.holiday-plans.pdf',['holiday_plan' => 1 ])
        )
        ->assertStatus(Response::HTTP_NOT_FOUND);
});

it('should be able to holiday plan link file in the pdf generate route', function () {
    
    $data = HolidayPlan::factory()->createOne();
    $user = User::factory()->create();

    $this->actingAs($user)
        ->getJson(
            route('api.holiday-plans.pdf',['holiday_plan' => $data->id ]
        ))
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'link_pdf',
                'holiday_plan' => [
                    'id',
                    'title',
                    'description',
                    'date',
                    'location',
                    'created_at',
                ]
            ]
        ]);
});

it('should be able generate file pdf', function () {

    $holidayPlan = HolidayPlan::factory()->createOne();
    $pdf = HolidayPlanGeneratePdfFacade::make(
        $holidayPlan
    );
    
    expect($pdf)->toBeObject();
    expect($pdf->url)->toBeUrl();
});