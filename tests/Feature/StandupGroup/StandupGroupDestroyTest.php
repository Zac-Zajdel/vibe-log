<?php

declare(strict_types=1);

use App\Models\StandupGroup;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('Delete Standup Group', function () {
    $standupGroup = StandupGroup::factory()
        ->for($this->user, 'owner')
        ->create();

    $this
        ->actingAs($this->user)
        ->deleteJson(route('standup-groups.destroy', $standupGroup))
        ->assertStatus(Response::HTTP_NO_CONTENT);

    $this->assertDatabaseMissing('standup_groups', [$standupGroup]);
});
