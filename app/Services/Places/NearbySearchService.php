<?php

namespace App\Services\Places;

use App\Models\Polygon;
use App\Models\Type;
use App\Services\Logs\VendorLogService;
use Illuminate\Support\Facades\Http;

//https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=48.533483,26.491300&radius=3000&type=tourist_attraction&keyword=museum&key=AIzaSyD3xO6BVrYHeD-sgkUbpEU6UjtWEWpYEdw
class NearbySearchService
{
    const STAT_CLASS_NAME = 'NearbySearchService';
    protected string $url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json';

    public function getPlaces(Polygon $polygon, Type $type): array
    {
        $places = $this->request([
            'location'   => implode(',', [$polygon->lat, $polygon->lon]),
            'radius'   => $polygon->radius,
            'type'   => $type->title ?? null,
        ]);

        return $places['results'] ?? [];
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

        $data = $response->json();

        if(isset($data['error_message']) && $data['error_message']) {
            dd($data['error_message']);
        }

        return $data;
    }

}
