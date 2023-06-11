<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreTravelRequest;
use App\Http\Requests\V1\UpdateTravelRequest;
use App\Http\Resources\V1\TravelResource;
use App\Models\Travel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TravelController extends Controller
{
    public function index(): JsonResponse
    {
        if (is_null(Auth::user())) {
            $travels = Travel::whereIsPublic(true)->paginate();

            return TravelResource::collection($travels)
                ->response()
                ->setStatusCode(JsonResponse::HTTP_OK);
        }

        return TravelResource::collection(Travel::paginate())
            ->response()
            ->setStatusCode(JsonResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTravelRequest $request): JsonResponse
    {
        return (new TravelResource(Travel::create($request->safe()->all())))
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(Travel $travel)
    // {
    //     //
    // }

    public function update(UpdateTravelRequest $request, Travel $travel): JsonResponse
    {
        $travel->fill($request->safe()->all());
        $travel->save();

        return response()->json(status: JsonResponse::HTTP_NO_CONTENT);
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Travel $travel)
    // {
    //     //
    // }
}
