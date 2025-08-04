<?php

declare(strict_types=1);

use App\Data\Resource\StandupGroup\StandupGroupResource;
use App\Enums\StandupGroup\StandupGroupDay;
use App\Models\StandupGroup;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->standupGroup = StandupGroup::factory()
        ->for($this->user, 'owner')
        ->for($this->user->activeWorkspace)
        ->create([
            'days' => [
                StandupGroupDay::MONDAY,
            ],
        ]);
});

it('Retrieve Standup Group', function () {
    $this
        ->actingAs($this->user)
        ->getJson(route('standup-groups.show', $this->standupGroup))
        ->assertOk()
        ->assertJsonFragment([
            'status' => 'success',
            'message' => 'Standup Group retrieved successfully',
            'data' => StandupGroupResource::from($this->standupGroup->load('owner'))->toArray(),
        ]);
});
