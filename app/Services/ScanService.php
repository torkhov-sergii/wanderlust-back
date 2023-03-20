<?php

namespace App\Services;

use App\Models\Place;
use App\Models\Polygon;
use App\Models\Logs;
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

    public function scanPolygon(): void
    {
        /** @var Polygon $polygon */
        $polygon = Polygon::query()
            ->where('disabled', '!=', 1)
            ->with(['types' => function($query) {
                $query->where('done', '=', 0);
            }])
            ->whereHas('types', function($query) {
                $query->where('done', '=', 0);
            })
            ->first();

        if ($polygon) {
            $radius = $polygon->radius;

            $firstType = $polygon->types->first();

            $places = $this->nearbySearchService->getPlaces($polygon, $firstType);

            dump("polygon id=$polygon->id, type=$firstType->title");

            //$countPlacesBefore = Places::query()->count('*');

            if ($places) {
                dump("Found places");
                dump($places);

                $lastPlacesId = Place::query()->max('id') ?? 0;

                $this->addPlaces($polygon, $places, $firstType);

                $addedPlaces = Place::query()->where('id', '>', $lastPlacesId)->get()->toArray();

//                // Исключаем если места содержат мусорные теги
//                $excludeTags = Place::EXCLUDE_TAGS;
//                $addedPlacesExcluded = [];
//                foreach ($addedPlaces as $place) {
//                    if (count(array_intersect($place['types'], $excludeTags)) === 0) {
//                        $addedPlacesExcluded[] = $place;
//                    };
//                }

                // Сортируем по ratings_total
                usort($addedPlaces, function($a, $b) {
                    return ($a['ratings_total'] <=> $b['ratings_total']);
                });
                $addedPlaces = array_reverse($addedPlaces);

                dump("Added places");
                dump($addedPlaces);

                $bestPlaceByRatingTotal = $addedPlaces[0] ?? null;

                dump('bestPlaceByRatingTotal', $bestPlaceByRatingTotal);

                $maxPlaceRatingTotal = $bestPlaceByRatingTotal['ratings_total'] ?? null;

                $countAddedPlaces = count($addedPlaces) ?? 0;

                dump("countAddedPlaces: $countAddedPlaces" );

                if(count($places) === 20) {
                    if ( $radius < 1000 ) {
//                        Logs::create([
//                            'message' => "polygon_id: $polygon->id, нет смысла смотреть слишком близко",
//                        ])->save();

                        $polygon->update([
                            'message' => "Нет смысла смотреть слишком близко"
                        ]);

                        dump("STOP: Нет смысла смотреть слишком близко" );
                    }
                    elseif ( $maxPlaceRatingTotal < 100 ) {
//                        Logs::create([
//                            'message' => "polygon_id: $polygon->id, рейтинг точек слишком низний",
//                        ])->save();

                        $polygon->update([
                            'message' => "Рейтинг точек слишком низкий"
                        ]);

                        dump("STOP: Рейтинг точек слишком низкий" );
                    }
                    elseif ( $countAddedPlaces === 0 ) {
//                        Logs::create([
//                            'message' => "polygon_id: $polygon->id, нет новых точек",
//                        ])->save();

                        $polygon->update([
                            'message' => "Нет новых точек",
                        ]);

                        dump("STOP: Нет новых точек" );
                    }
                    else {
                        $this->addPolygon($polygon, $firstType);
                        dump("КОПАЕМ ГЛУБЖЕ" );
                    }
                }
            }

            $firstType->pivot->done = 1;
            $firstType->pivot->save();
        }
        else {
            dump('fin');
        }
    }

    // Добавить новые точки в бд
    private function addPlaces($polygon, $places, $polygonType)
    {
        $root_polygon_id = $polygon->root_polygon_id ?? $polygon->id;

        foreach ($places as $place) {
            $data = [
                'root_polygon_id' => $root_polygon_id,
                'polygon_type_id' => $polygonType->id,
                'polygon_id' => $polygon->id,
                'title' => $place['name'],
                'place_id' => $place['place_id'],
                'rating' => $place['rating'] ?? null,
                'ratings_total' => $place['user_ratings_total'] ?? null,
                'types' => $place['types'] ?? null,
                'lat' => $place['geometry']['location']['lat'],
                'lon' => $place['geometry']['location']['lng'],
            ];

            Place::query()
                ->firstOrCreate([
                    'place_id' => $place['place_id'],
                ], $data);
        }
    }

    // Если точек много, углубится
    private function addPolygon($polygon, $type)
    {
        $lat = $polygon->lat;
        $lon = $polygon->lon;
        $radius = $polygon->radius;

        $newPoi = $this->get4CircleOverlap($lat, $lon, $radius);
        $newRadius = $this->get4CircleOverlapRadius($radius);

        $root_polygon_id = $polygon->root_polygon_id ?? $polygon->id;

        foreach ($newPoi as $poi) {
            $newPolygon = Polygon::query()
                ->create([
                    'root_polygon_id' => $root_polygon_id,
                    'parent_id' => $polygon->id,
                    'depth' => $polygon->depth + 1,
                    'lat' => $poi->lat,
                    'lon' => $poi->lon,
                    'radius' => $newRadius,
                ]);

            //$parentPolygon = Polygon::query()->where('id', $newPolygon->parent_id)->first();
            $newPolygon->types()->sync($type);
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
