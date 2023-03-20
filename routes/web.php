<?php

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

Route::match(['get'], '/', [PageController::class, 'home']);
Route::match(['get', 'post'], '/scan/', [PageController::class, 'scan']);
Route::match(['get'], '/polygon/{id}/', [PageController::class, 'polygon']);
