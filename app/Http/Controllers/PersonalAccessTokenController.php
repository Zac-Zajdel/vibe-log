<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\Request\PersonalAccessToken\PersonalAccessTokenStoreData;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class PersonalAccessTokenController extends Controller
{
    public function store(PersonalAccessTokenStoreData $data): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $token = $user->createToken($data->name);

        return $this->success(
            ['token' => $token->plainTextToken],
            'API Token created successfully. Please copy the token and save it in a secure location.',
            Response::HTTP_CREATED,
        );
    }
}
