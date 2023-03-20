<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreatePolygonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 173 полигона - $radius < 1000, $maxPlaceRatingTotal < 100
        DB::table('polygon')->insert([
            'title' => 'Neustadt 5000',
            'lat' => '49.358',
            'lon' => '8.099',
            'radius' => 5000,
        ]);
    }
}
