<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTravelRequest;
use App\Http\Requests\UpdateTravelRequest;
use App\Models\Travel;
use App\Repositories\TravelRepository;
use App\Services\TravelService;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;

class TravelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $travels = QueryBuilder::for(Travel::class)
            ->paginate();

        return response()->json($travels);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTravelRequest $request
     * @param TravelService $travelService
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(
        StoreTravelRequest $request,
        TravelService $travelService,
    ): JsonResponse {
        $travel = $travelService
            ->create(
                originId: $request->input('origin_id'),
                destinationId: $request->input('destination_id'),
                scheduledTo: $request->date('scheduled_to')
            );

        return response()->json($travel);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Travel  $travel
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Travel $travel): JsonResponse
    {
        return response()->json($travel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTravelRequest $request
     * @param \App\Models\Travel $travel
     * @param TravelRepository $travelRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTravelRequest $request, Travel $travel, TravelRepository $travelRepository): JsonResponse
    {
        $updatedTravel = $travelRepository
            ->setTravel($travel)
            ->update($request->all())
            ->getTravel();

        return response()->json($updatedTravel);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Travel  $travel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Travel $travel)
    {
        $travel->delete();

        return response()->noContent();
    }
}
