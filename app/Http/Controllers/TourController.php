<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\FilterSortRequest;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FilterSortRequest $request, Travel $travel): JsonResponse
    {
        $this->authorize('view', $travel);
        $query = $travel->tours()->filter($request->validated());
        if ($request->has('price')) {
            $query = $query->orderBy('price', $request->price);
        }
        $tours = $query
            ->orderBy('starting_date', 'asc')
            ->paginate();

        return response()
            ->json($tours, JsonResponse::HTTP_ACCEPTED);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(Tour $tour)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Tour $tour)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Tour $tour)
    // {
    //     //
    // }
}
