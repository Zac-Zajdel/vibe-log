<?php

declare(strict_types=1);

namespace App\Data\Resource\User;

use App\Data\Resource\Workspace\WorkspaceResource;
use App\Models\User;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Resource;

final class UserResource extends Resource
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?CarbonImmutable $email_verified_at,
        public ?string $remember_token,
        public ?int $active_workspace_id,
        public ?CarbonImmutable $created_at,
        public ?CarbonImmutable $updated_at,
        public Lazy|WorkspaceResource $active_workspace,
    ) {}

    public static function fromModel(User $user): self
    {
        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            email_verified_at: $user->email_verified_at ? CarbonImmutable::parse($user->email_verified_at) : null,
            remember_token: $user->remember_token,
            active_workspace_id: $user->active_workspace_id,
            created_at: $user->created_at,
            updated_at: $user->updated_at,
            active_workspace: Lazy::whenLoaded(
                'activeWorkspace',
                $user,
                fn () => $user->activeWorkspace ? WorkspaceResource::fromModel($user->activeWorkspace) : null,
            ),
        );
    }
}
