<?php

declare(strict_types=1);

namespace App\Data\Request\WorkspaceUser;

use App\Enums\Workspace\WorkspaceUserRole;
use App\Models\User;
use Closure;
use Illuminate\Validation\Rules\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Support\Validation\ValidationContext;

final class WorkspaceUserStoreData extends Data
{
    public string $email;

    public Optional|WorkspaceUserRole $role = WorkspaceUserRole::MEMBER;

    /**
     * @return array<string, array<int, string|Unique|\Illuminate\Validation\Rules\Exists|Closure>>
     */
    public static function rules(ValidationContext $context): array
    {
        return [
            'email' => [
                'required',
                'email',
                function (string $attribute, $value, Closure $fail) {
                    $user = User::whereEmail($value)->first();

                    if (! $user) {
                        $fail('We could not find a user with this email. Please check the email and try again.');
                    }

                    if ($user?->workspaceUsers()->whereBelongsTo(activeWorkspace())->exists()) {
                        $fail('The user already belongs to this workspace.');
                    }
                },
            ],
        ];
    }
}
