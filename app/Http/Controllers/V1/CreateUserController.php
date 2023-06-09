<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class CreateUserController extends Controller
{
    public function __invoke(CreateUserRequest $request): JsonResponse
    {
        return response()
            ->json(new UserResource(User::create($request->validated())))
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }
}
