<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use App\Repositories\AddressRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $address = QueryBuilder::for(Address::class)
            ->paginate();

        return response()->json($address);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreAddressRequest $request
     * @param AddressRepository $addressRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAddressRequest $request, AddressRepository $addressRepository): JsonResponse
    {
        $address = $addressRepository->create([
            'street' => $request->input('street'),
            'number' => $request->input('number'),
            'neighborhood' => $request->input('neighborhood'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'postal_code' => $request->input('postal_code'),
        ])->getAddress();

        return response()->json($address);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Address $address): JsonResponse
    {
        return response()->json($address);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateAddressRequest $request
     * @param \App\Models\Address $address
     * @param AddressRepository $addressRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        UpdateAddressRequest $request,
        Address $address,
        AddressRepository $addressRepository
    ): JsonResponse {
        $updatedAddress = $addressRepository
            ->setAddress($address)
            ->update([
                'street' => $request->input('street'),
                'number' => $request->input('number'),
                'neighborhood' => $request->input('neighborhood'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'postal_code' => $request->input('postal_code'),
            ])
            ->getAddress();

        return response()->json($updatedAddress);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address): Response
    {
        $address->delete();

        return response()->noContent();
    }
}
