<?php

declare(strict_types=1);

namespace App\Data\Transfer\User;

use Spatie\LaravelData\Dto;

final class UserData extends Dto
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $password = null,
    ) {}
}
