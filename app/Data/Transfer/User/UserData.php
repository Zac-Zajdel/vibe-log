<?php

declare(strict_types=1);

namespace App\Data\Transfer\User;

use Spatie\LaravelData\Concerns\TransformableData;
use Spatie\LaravelData\Contracts\TransformableData as ContractsTransformableData;
use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class UserData extends Dto implements ContractsTransformableData
{
    use TransformableData;

    public function __construct(
        public readonly Optional|string $name,
        public readonly Optional|string $email,
        public readonly Optional|string $password,
        public readonly Optional|int $active_workspace_id,
    ) {}
}
