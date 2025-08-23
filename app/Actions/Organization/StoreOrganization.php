<?php

declare(strict_types=1);

namespace App\Actions\Organization;

use App\Data\Request\Organization\OrganizationStoreData;
use App\Models\Organization;
use Lorisleiva\Actions\Concerns\AsAction;

final class StoreOrganization
{
    use AsAction;

    public function handle(OrganizationStoreData $data): Organization
    {
        $organization = tap(
            Organization::create($data->toArray()),
            fn (Organization $organization) => $organization->refresh(),
        );

        // TODO - Add user to pivot.

        return $organization;
    }
}
