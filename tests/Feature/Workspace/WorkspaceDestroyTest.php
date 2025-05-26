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

it('Delete Workspace', function () {
    $this
        ->actingAs($this->user)
        ->deleteJson(route('workspaces.destroy', $this->workspace))
        ->assertStatus(Response::HTTP_NO_CONTENT);

    $this->assertDatabaseMissing('workspaces', [$this->workspace]);
});
