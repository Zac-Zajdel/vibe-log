<?php

declare(strict_types=1);

use App\Data\Resource\Workspace\WorkspaceResource;
use App\Data\Transfer\Workspace\WorkspaceData;
use App\Models\User;
use App\Models\Workspace;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('Create Workspace', function () {
    $workspaceData = new WorkspaceData(
        owner_id: $this->user->id,
        name: fake()->unique()->company(),
        description: 'Your personal workspace',
        logo: 'https://via.placeholder.com/150',
    );

    $response = $this
        ->actingAs($this->user)
        ->postJson(
            route('workspaces.store'),
            $workspaceData->toArray(),
        )
        ->assertStatus(Response::HTTP_CREATED);

    $createdWorkspace = Workspace::orderByDesc('id')->first();

    $response->assertJsonFragment([
        'status' => 'success',
        'message' => 'Workspace created successfully',
        'data' => WorkspaceResource::from($createdWorkspace)->toArray(),
    ]);
});
