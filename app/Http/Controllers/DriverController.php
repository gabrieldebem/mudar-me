<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\Driver;
use App\Repositories\DriverRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $driver = QueryBuilder::for(Driver::class)
            ->paginate();

        return response()->json($driver);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreDriverRequest $request
     * @param DriverRepository $driverRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDriverRequest $request, DriverRepository $driverRepository): JsonResponse
    {
        $driver = $driverRepository
            ->create([
                'name' => $request->input('name'),
                'document' => $request->input('document'),
                'truck' => $request->input('truck'),
                'amount_km' => $request->input('amount_km'),
            ])->getDriver();

        return response()->json($driver);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Driver $driver): JsonResponse
    {
        return response()->json($driver);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateDriverRequest $request
     * @param \App\Models\Driver $driver
     * @param DriverRepository $driverRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        UpdateDriverRequest $request,
        Driver $driver,
        DriverRepository $driverRepository)
    : JsonResponse {
        $updatedDriver = $driverRepository
            ->setDriver($driver)
            ->update($request->all())
            ->getDriver();

        return response()->json($updatedDriver);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver): Response
    {
        $driver->delete();

        return response()->noContent();
    }
}
