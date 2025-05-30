<?php

declare(strict_types=1);

use App\Data\Resource\User\UserResource;
use App\Models\User;
use App\Models\Workspace;
use Symfony\Component\HttpFoundation\Response;

it('Register User', function () {
    $response = $this
        ->postJson(
            route('user.register'),
            [
                'name' => 'Test User',
                'email' => 'test@gmail.com',
                'password' => 'hello_world',
                'password_confirmation' => 'hello_world',
            ],
        );

    $workspace = Workspace::latest()->first();
    $user = User::with('activeWorkspace')->latest()->first();

    $response
        ->assertStatus(Response::HTTP_CREATED)
        ->assertJsonFragment([
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => UserResource::from($user)->toArray(),
        ]);

    // Check if the user is logged in and has the correct ID.
    expect(auth()->check())->toBeTrue();
    expect(auth()->id())->toBe($user->id);

    // Check if the user is created in the database.
    expect($user->name)->toBe('Test User');
    expect($user->email)->toBe('test@gmail.com');
    expect($user->active_workspace_id)->toBe($workspace->id);

    // Check if the default workspace is created and associated with the user.
    expect($workspace->owner_id)->toBe($user->id);
    expect($workspace->name)->toBe('Default Workspace');
    expect($workspace->description)->toBe('Your personal workspace');
});
