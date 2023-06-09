<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreTravelRequest;
use App\Http\Requests\V1\UpdateTravelRequest;
use App\Models\Travel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TravelController extends Controller
{
    public function index(): JsonResponse
    {
        if (is_null(Auth::user())) {
            $travels = Travel::whereIsPublic(true)->paginate();

            return response()
                ->json($travels, JsonResponse::HTTP_ACCEPTED);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTravelRequest $request): JsonResponse
    {
        return response()
            ->json(
                Travel::create($request->validated())
            )->setStatusCode(JsonResponse::HTTP_CREATED);
    }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(Travel $travel)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(UpdateTravelRequest $request, Travel $travel)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Travel $travel)
    // {
    //     //
    // }
}
