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
     * @param TravelRepository $travelRepository
     * @param TravelService $travelService
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(
        StoreTravelRequest $request,
        TravelRepository $travelRepository,
        TravelService $travelService
    ): JsonResponse {

        $travel = $travelRepository->create(
            originId: $request->input('origin_id'),
            destinationId: $request->input('destination_id'),
            driverId: $driver,
            amount: $travelService->calcFinalAmount($driver),
        );
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
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTravelRequest $request, Travel $travel, TravelRepository $travelRepository)
    {
        $travelRepository->update($request->all());
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
