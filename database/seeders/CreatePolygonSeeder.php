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
        DB::table('polygon')->insert([
            'lat' => '48.543859',
            'lon' => '26.496982',
            'radius' => 100,
        ]);
    }
}
