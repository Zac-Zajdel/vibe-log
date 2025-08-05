<?php

declare(strict_types=1);

use App\Models\StandupGroup;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->workspaceUser = $this->user->workspaceUsers()->first();
});

it('Delete Standup Group', function () {
    $standupGroup = StandupGroup::factory()
        ->for($this->workspaceUser, 'owner')
        ->for($this->user->activeWorkspace)
        ->create();

    $this
        ->actingAs($this->user)
        ->deleteJson(route('standup-groups.destroy', $standupGroup))
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonFragment([
            'status' => 'success',
            'message' => 'Standup Group deleted successfully',
        ]);

    $this->assertDatabaseMissing('standup_groups', [$standupGroup]);
});
