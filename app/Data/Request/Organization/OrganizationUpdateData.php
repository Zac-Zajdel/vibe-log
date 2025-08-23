<?php

declare(strict_types=1);

namespace App\Data\Request\Organization;

use App\Models\User;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

final class OrganizationUpdateData extends Data
{
    // TODO - Must belongs to the organization.
    #[Exists(User::class, 'id')]
    public int $owner_id;

    #[Min(3), Max(255)]
    public Optional|string $name;

    #[Max(255)]
    public Optional|string|null $avatar;

    #[Max(1000)]
    public Optional|string|null $description;
}
