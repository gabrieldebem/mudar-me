<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTravelRequest;
use App\Http\Requests\UpdateTravelRequest;
use App\Models\Address;
use App\Models\Travel;
use App\Repositories\DriverRepository;
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
     * @param DriverRepository $driverRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(
        StoreTravelRequest $request,
        TravelRepository $travelRepository,
        TravelService $travelService,
        DriverRepository $driverRepository,
    ): JsonResponse {
        $origin = Address::find($request->input('origin_id'));
        $destination = Address::find($request->input('destination_id'));
        $driver = $driverRepository->getDriverWithoutTravelsSchedule();

        $travel = $travelRepository->create(
            originId: $origin->id,
            destinationId: $destination->id,
            driverId: $driver->id,
            amount: $travelService->calcFinalAmount($driver, $destination, $origin),
            scheduledTo: $request->date('scheduled_to')
        )->getTravel();

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
