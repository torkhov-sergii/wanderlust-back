<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Polygon;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function updateUserRating(Request $request)
    {
        $placeId = $request->get('placeId');
        $userRating = $request->get('userRating');

        $place = Place::query()
            ->where('id', $placeId)
            ->first();

        $place->update([
            'user_rating' => $userRating
        ]);
    }

}
