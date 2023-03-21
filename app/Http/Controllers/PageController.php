<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Polygon;
use App\Services\ScanService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected ScanService $scanService;

    public function __construct(ScanService $scanService)
    {
        $this->scanService = $scanService;
    }

    public function home()
    {
        $polygons = Polygon::all();

        return view('home', [
            'polygons' => $polygons,
        ]);
    }

    public function scan()
    {
        $this->scanService->scanPolygon();

        return view('scan', [
        ]);
    }

    public function polygon(Request $request, $id)
    {
        $minRating = $request->get('min_rating') ?? 10;
        $selectedTypes = $request->get('type') ?? null;

        $excludeTags = Place::EXCLUDE_TAGS;

        $polygon = Polygon::where('id', $id)->first();

        $places_query = $polygon->places()
            ->orderBy('ratings_total', 'desc')
            ->where(function($q) use($excludeTags) {
                foreach ($excludeTags as $tag) {
                    $q->where('types', 'NOT LIKE', '%'.$tag.'%');
                }
            })
            ->where('ratings_total', '>', $minRating)
            ->where('polygon_type_id', '=', 5);

        if ($selectedTypes) {
            $places_query->where(function($q) use($selectedTypes) {
                foreach ($selectedTypes as $type) {
                    $q->orWhereJsonContains('types', $type);
                }
            });
        }

        $places = $places_query->get();

        $types = $this->getTypes();

        return view('polygon', [
            'polygon' => $polygon,
            'places' => $places,
            'types' => $types,
            'selectedTypes' => $selectedTypes,
            'minRating' => $minRating,
        ]);
    }

    public function types()
    {
        $types = $this->getTypes();

        dump($types);

        return view('types', [
        ]);
    }

    private function getTypes()
    {
        $excludeTags = Place::EXCLUDE_TAGS;

        $types = [];
        $places_query = Place::query()
            ->orderBy('ratings_total', 'desc')
            ->where(function($q) use($excludeTags) {
                foreach ($excludeTags as $tag) {
                    $q->where('types', 'NOT LIKE', '%'.$tag.'%');
                }
            });

        $places = $places_query->get();

        foreach ($places as $place) {
            foreach ($place->types as $type) {
                $types[$type] = isset($types[$type]) ? $types[$type]+1 : 0;
            }
        }

        asort($types);

        $types = array_reverse($types);

        unset($types['establishment']);

        return $types;
    }
}
