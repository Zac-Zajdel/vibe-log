<?php

declare(strict_types=1);

namespace App\Actions\Organization;

use App\Data\Request\Organization\OrganizationUpdateData;
use App\Models\Organization;
use Lorisleiva\Actions\Concerns\AsAction;

final class UpdateOrganization
{
    use AsAction;

    public function handle(Organization $organization, OrganizationUpdateData $data): Organization
    {
        return tap(
            $organization,
            fn (Organization $organization) => $organization->update($data->toArray()),
        );
    }
}
