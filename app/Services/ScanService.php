<?php

namespace App\Services;

use App\Models\Places;
use App\Models\Polygon;
use App\Services\Places\NearbySearchService;
use Illuminate\Database\Eloquent\Collection;

class ScanService
{
    protected NearbySearchService $nearbySearchService;

    public function __construct(NearbySearchService $nearbySearchService)
    {
        $this->nearbySearchService = $nearbySearchService;
    }

    public function allPolygons(): Collection
    {
        return Polygon::query()
            ->get();
    }

    public function scanPolygon()
    {
        /** @var Polygon $polygon */
        $polygon = Polygon::query()
            ->where('done', 0)
            ->first();

        if ($polygon) {
            $places = $this->nearbySearchService->getPlaces($polygon);

            // Добавить новые точки в бд
            foreach ($places['results'] as $place) {
                $data = [
                    'name' => $place['name'],
                    'place_id' => $place['place_id'],
                    'rating' => $place['rating'] ?? null,
                    'ratings_total' => $place['user_ratings_total'] ?? null,
                    'types' => $place['types'] ?? null,
                    'lat' => $place['geometry']['location']['lat'],
                    'lon' => $place['geometry']['location']['lng'],
                ];

                Places::query()
                    ->firstOrCreate([
                        'place_id' => $place['place_id'],
                    ], $data);
            }

            // Если точек много, углубится
            if(count($places['results']) === 20) {
                $lat = $polygon->lat;
                $lon = $polygon->lon;
                $radius = $polygon->radius;

                $newPoi = $this->get4CircleOverlap($lat, $lon, $radius);
                $newRadius = $this->get4CircleOverlapRadius($radius);

                foreach ($newPoi as $poi) {
                    Polygon::query()
                        ->create([
                            'parent_id' => $polygon->id,
                            'depth' => $polygon->depth + 1,
                            'lat' => $poi->lat,
                            'lon' => $poi->lon,
                            'radius' => $newRadius,
                        ]);
                }
            }

            $polygon->update([
                'done' => 1
            ]);
        }
    }

    //41
    //32
    //кординаты новых четырех кругов
    private function get4CircleOverlap($lat, $lon, $radius): array
    {
        $poi_1 = $this->addDistanceToCord($lat, $lon, $radius/2, $radius/2);
        $poi_2 = $this->addDistanceToCord($lat, $lon, -$radius/2, $radius/2);
        $poi_3 = $this->addDistanceToCord($lat, $lon, -$radius/2, -$radius/2);
        $poi_4 = $this->addDistanceToCord($lat, $lon, $radius/2, -$radius/2);

        return [ $poi_1, $poi_2, $poi_3, $poi_4 ];
    }

    //радиус нового меньшего круга
    private function get4CircleOverlapRadius($radius): int
    {
        return hypot($radius/2, $radius/2);
    }

    //$lat_meters - вверх
    //$lon_meters - вправо
    private function addDistanceToCord($lat, $lon, $lat_meters = 0, $lon_meters = 0): object
    {
        $latCoef = $lat_meters * 0.0000089;
        $lonCoef = $lon_meters * 0.0000089;

        $newLat = $lat + $latCoef;
        $newLon = $lon + $lonCoef / cos($lat * 0.018);

        return (object) ['lat' => $newLat, 'lon' => $newLon];
    }

}
