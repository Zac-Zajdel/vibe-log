<?php

declare(strict_types=1);

namespace App\Data\Resource\StandupUser;

use App\Data\Resource\StandupGroup\StandupGroupResource;
use App\Data\Resource\User\UserResource;
use App\Models\StandupUser;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Resource;

final class StandupUserResource extends Resource
{
    public function __construct(
        public int $id,
        public int $standup_group_id,
        public int $user_id,
        public bool $is_active,
        public ?CarbonImmutable $created_at,
        public ?CarbonImmutable $updated_at,
        public Lazy|UserResource $user,
        public Lazy|StandupGroupResource $standupGroup,
    ) {}

    public static function fromModel(StandupUser $standupUser): self
    {
        return new self(
            id: $standupUser->id,
            standup_group_id: $standupUser->id,
            user_id: $standupUser->user_id,
            is_active: $standupUser->is_active,
            created_at: $standupUser->created_at,
            updated_at: $standupUser->updated_at,
            user: Lazy::whenLoaded(
                'user',
                $standupUser,
                fn (): UserResource => UserResource::fromModel($standupUser->user),
            ),
            standupGroup: Lazy::whenLoaded(
                'standupGroup',
                $standupUser,
                fn (): StandupGroupResource => StandupGroupResource::fromModel($standupUser->standupGroup),
            ),
        );
    }
}
