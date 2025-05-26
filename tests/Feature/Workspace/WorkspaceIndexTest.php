<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\Workspace;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->workspace = Workspace::factory()
        ->for($this->user, 'owner')
        ->create();
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
            'name' => $this->workspace->name,
            'description' => $this->workspace->description,
            'logo' => $this->workspace->logo,
        ]);
});
