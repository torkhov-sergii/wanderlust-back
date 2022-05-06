<?php

namespace App\Services\Places;

use App\Models\Polygon;
use App\Services\Logs\VendorLogService;
use Illuminate\Support\Facades\Http;

class NearbySearchService
{
    const STAT_CLASS_NAME = 'NearbySearchService';
    protected string $url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json';

    public function getPlaces(Polygon $polygon): array
    {
        return $this->request([
            'location'   => implode(',', [$polygon->lat, $polygon->lon]),
            'radius'   => $polygon->radius,
        ]);
    }

    protected function request(array $data): array
    {
        $response = Http::get($this->url, array_merge($data, [
            'key' => config('services.google.key'),
        ]));

        if ($response->failed()){
            VendorLogService::writeError($response->body(), self::STAT_CLASS_NAME, $response->status(), $data);
        }
        $response->throw();

        return $response->json();
    }

}
