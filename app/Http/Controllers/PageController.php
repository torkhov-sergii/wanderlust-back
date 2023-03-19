<?php

namespace App\Http\Controllers;

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
        $polygon = Polygon::where('id', $id)->first();
        $places = $polygon->places()->orderBy('ratings_total', 'desc')->get();

        return view('polygon', [
            'polygon' => $polygon,
            'places' => $places,
        ]);
    }
}
