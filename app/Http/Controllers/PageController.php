<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Polygon;
use App\Models\Type;
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
        $polygons = Polygon::query()
        ->where('depth', 0)
        ->get();

        return view('home', [
            'polygons' => $polygons,
        ]);
    }

    public function scan(Request $request)
    {
        $radius = $request->get('radius');
        $root_polygon_id = $request->get('root_polygon_id');
        $reload = $request->get('reload');
        $limit_per_day = $request->get('limit_per_day');

        if (!$radius) dd('Set get param min "radius", до какого радиуса продолжать');
        if (!$root_polygon_id) dd('Set get param "root_polygon_id", id страны или корневого полегона');
        if (!isset($reload)) dd('Set get param "reload", обновлять ли страницу автоматически');
        if (!$limit_per_day) dd('Set get param "limit_per_day", лимит API запросов за сегодня');

        $this->scanService->scanPolygon($radius, $root_polygon_id, $reload, $limit_per_day);

        return view('scan', [
        ]);
    }

    public function polygon(Request $request, $id)
    {
        $minRating = $request->get('min_rating') ?? 100;
        $limit = $request->get('limit') ?? 100;
        $selectedTypes = $request->get('type') ?? null;
        $selectedStyle = $request->get('style') ?? 'list';

        $excludeTags = Type::EXCLUDE_TAGS;

        $polygon = Polygon::where('id', $id)->first();

        $places_query = $polygon->places()
            ->where(function($q) use($excludeTags) {
                foreach ($excludeTags as $tag) {
                    $q->where('types', 'NOT LIKE', '%'.$tag.'%');
                }
            })
            ->where('ratings_total', '>', $minRating)
            ->where('polygon_type_id', '!=', 50);

        if ($selectedTypes) {
            $places_query->where(function($q) use($selectedTypes) {
                foreach ($selectedTypes as $type) {
                    $q->orWhereJsonContains('types', $type);
                }
            });
        }

        if ($selectedStyle == 'map') {
            $places_query->orderBy('user_rating', 'asc');
        } else {
            $places_query->orderBy('ratings_total', 'desc');
        }

        $places = $places_query->limit($limit);

        $places = $places_query->get();

        $types = Type::INCLUDE_TAGS;

        return view('polygon', [
            'polygon' => $polygon,
            'places' => $places,
            'types' => $types,
            'selectedTypes' => $selectedTypes,
            'minRating' => $minRating,
            'limit' => $limit,
            'selectedStyle' => $selectedStyle,
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
        $excludeTags = Type::EXCLUDE_TAGS;

        $types = [];
        $places_query = Place::query()
            ->orderBy('ratings_total', 'desc')
            ->where(function($q) use($excludeTags) {
                foreach ($excludeTags as $tag) {
                    $q->where('types', 'NOT LIKE', '%'.$tag.'%');
                }
            });

        $places = $places_query->limit(20000)->get();

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

    public function countRequests(Request $request)
    {
        $radius = $request->get('radius');

        $i = 1;
        $total_requests = 1;
        for ($r = $radius; $r > 1000; $r = $r/1.41) {

            $requests[] = [
                'radius' => round($r),
                'requests' => $i,
                'total_requests' => $total_requests,
            ];

            $i = $i * 4;
            $total_requests = $total_requests + $i;
        }

//        $requests[]
//        dd($requests);

        return view('requests', [
            'radius' => $radius,
            'requests' => $requests,
        ]);
    }
}
