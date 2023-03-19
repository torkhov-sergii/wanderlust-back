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
//        DB::table('polygon')->insert([
//            'lat' => '48.533483',
//            'lon' => '26.491300',
//            'radius' => 30000,
//        ]);

//        DB::table('polygon')->insert([
//            'title' => 'Test',
//            'lat' => '50.84588',
//            'lon' => '9.70227',
//            'radius' => 5000,
//        ]);

        DB::table('polygon')->insert([
            'title' => 'Neustadt',
            'lat' => '49.358',
            'lon' => '8.099',
            'radius' => 2000,
        ]);
    }
}
