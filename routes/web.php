<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//$polygon = \App\Models\Polygon::where('id', 1)->first();
//dd($polygon);
//dd($polygon->getSiblingPolygonsIds());
//dd($polygon->places);
//$exclude = ['qqq', 'eee'];
//
//$arr = [
//  [
//      'id' => 1,
//      'rating' => 2,
//      'tags' => ['qqq', 'www'],
//  ],
//  [
//      'id' => 2,
//      'rating' => 5,
//      'tags' => ['www'],
//  ],
//  [
//      'id' => 3,
//      'rating' => 3,
//      'tags' => ['qqq', 'www', 'eee'],
//  ],
//];
//
////usort($arr, fn($a, $b) => $a['rating'] <=> $b['rating']);
//usort($arr, function($a, $b) use($exclude) {
////    dd(count(array_intersect($a['tags'], $exclude)));
//    return $a['rating'] != $b['rating'] && count(array_intersect($a['tags'], $exclude)) === 0;
//});
//
//$arr = array_reverse($arr);
//
//dd($arr);

//$polygon = \App\Models\Polygon::create([
//    'title' => 'Tunisia South 10000',
//    'lat' => '32.969',
//    'lon' => ' 9.655',
//    'radius' => 10000,
//]);

//$polygon = \App\Models\Polygon::create([
//    'title' => 'Tunisia North 170000',
//    'lat' => '35.809',
//    'lon' => '9.687',
//    'radius' => 170000,
//]);
//
//$types = \App\Models\Type::all();
//foreach ($types as $type) {
//    \App\Models\PolygonType::create([
//        'polygon_id' => $polygon->id,
//        'type_id' => $type->id,
//    ]);
//}

// 34.305   9.593 350km

Route::match(['get'], '/', [PageController::class, 'home']);
Route::match(['get', 'post'], '/scan/', [PageController::class, 'scan']);
Route::match(['get'], '/polygon/{id}/', [PageController::class, 'polygon']);
Route::match(['get'], '/types/', [PageController::class, 'types']);
