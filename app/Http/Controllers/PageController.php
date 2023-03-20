<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Polygon;
use App\Services\ScanService;

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

    public function polygon($id)
    {
        $excludeTags = Place::EXCLUDE_TAGS;

        $polygon = Polygon::where('id', $id)->first();

        $places_query = $polygon->places()
            ->orderBy('ratings_total', 'desc')
            ->where(function($q) use($excludeTags) {
                foreach ($excludeTags as $tag) {
                    $q->where('types', 'NOT LIKE', '%'.$tag.'%');
                }
            });

        $places = $places_query->get();

        return view('polygon', [
            'polygon' => $polygon,
            'places' => $places,
        ]);
    }
}
