<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\Workspace;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->workspace = Workspace::factory()->create([
        'owner_id' => $this->user->id,
        'name' => 'Default Workspace',
        'description' => 'Your personal workspace',
        'logo' => 'https://via.placeholder.com/150',
        'archived_at' => null,
    ]);
});

it('Workspace index route', function () {
    $this
        ->actingAs($this->user)
        ->getJson(route('workspaces.index'))
        ->assertSuccess(
            status: Response::HTTP_OK,
            message: 'Workspaces retrieved successfully',
        )
        ->assertJsonFragment([
            'id' => $this->workspace->id,
            'name' => 'Default Workspace',
            'description' => 'Your personal workspace',
            'logo' => 'https://via.placeholder.com/150',
            'archived_at' => null,
        ]);
});
