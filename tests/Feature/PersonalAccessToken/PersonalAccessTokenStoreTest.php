<?php

declare(strict_types=1);

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('Create Personal Access Token', function () {
    $response = $this
        ->actingAs($this->user)
        ->postJson(route('tokens.store'), [
            'name' => 'Test Token Name',
        ])
        ->assertStatus(Response::HTTP_CREATED);

    $response->assertJsonFragment([
        'status' => 'success',
        'message' => 'API Token created successfully. Please copy the token and save it in a secure location.',
        'data' => [
            'token' => $response->json('data.token'),
        ],
    ]);
});
