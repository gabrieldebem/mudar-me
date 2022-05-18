<?php

namespace App\Services\Clients;

use Illuminate\Support\Facades\Http;

class GoogleMapsDistance
{
    private string $distanceApiUrl;
    private string $token;

    public function __construct()
    {
        $this->distanceApiUrl = config('services.google_maps.urls.distance_api');
        $this->token = config('services.google_maps.token');
    }

    private function api(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::baseUrl($this->distanceApiUrl);
    }

    public function getDistance(string $destination, string $origin): object
    {
        return $this->api()
            ->get('/json', [
                'destinations' => $destination,
                'origins' => $origin,
                'key' => $this->token,
            ])
            ->throw()
            ->object()
            ->rows->first()
            ->elements->first();
    }
}
