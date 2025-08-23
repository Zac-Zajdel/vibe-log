<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Organization\StoreOrganization;
use App\Actions\Organization\UpdateOrganization;
use App\Data\Request\Organization\OrganizationIndexData;
use App\Data\Request\Organization\OrganizationStoreData;
use App\Data\Request\Organization\OrganizationUpdateData;
use App\Data\Resource\Organization\OrganizationResource;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\PaginatedDataCollection;
use Symfony\Component\HttpFoundation\Response;

final class OrganizationController extends Controller
{
    public function index(OrganizationIndexData $data): JsonResponse
    {
        $organizations = Organization::query()
            // todo - filter by user being part of organization.
            ->when(
                $data->include instanceof Optional,
                fn (Builder $query) => $query->with($data->include),
            )
            ->paginate(
                perPage: $data->per_page,
                page: $data->page,
            );

        return $this->success(
            OrganizationResource::collect($organizations, PaginatedDataCollection::class),
            'Organizations retrieved successfully',
        );
    }

    public function store(OrganizationStoreData $data): JsonResponse
    {
        $organization = StoreOrganization::make()->handle(
            OrganizationStoreData::from($data),
        );

        return $this->success(
            OrganizationResource::from($organization->load('owner')),
            'Organization created successfully',
            Response::HTTP_CREATED,
        );
    }

    public function show(Organization $organization): JsonResponse
    {
        Gate::authorize('view', $organization);

        return $this->success(
            OrganizationResource::from($organization->load('owner')),
            'Organization retrieved successfully',
        );
    }

    public function update(OrganizationUpdateData $data, Organization $organization): JsonResponse
    {
        Gate::authorize('update', $organization);

        $organization = UpdateOrganization::make()->handle(
            $organization,
            OrganizationUpdateData::from($data),
        );

        return $this->success(
            OrganizationResource::from($organization->load('owner')),
            'Organization updated successfully',
        );
    }

    public function destroy(Organization $organization): JsonResponse
    {
        Gate::authorize('delete', $organization);

        // TODO - For Later we will need to a lot more here in a queued job.
        // TODO - 30 day retention policy w/ soft delete for restore and automatic pruning.
        $organization->delete();

        return $this->success(
            message: 'Organization deleted successfully',
        );
    }
}
