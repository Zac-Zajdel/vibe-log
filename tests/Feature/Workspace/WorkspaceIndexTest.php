<?php

declare(strict_types=1);

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->user = User::factory()->create();
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
            'id' => $this->user->activeWorkspace->id,
            'name' => $this->user->activeWorkspace->name,
            'description' => $this->user->activeWorkspace->description,
            'logo' => $this->user->activeWorkspace->logo,
        ]);
});
