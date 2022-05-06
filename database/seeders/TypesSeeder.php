<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['tourist_attraction', 'point_of_interest', 'museum', 'spa'];

        DB::table('types')->insert([
            'name' => 'tourist_attraction',
        ]);

        DB::table('types')->insert([
            'name' => 'point_of_interest',
        ]);


        DB::table('polygon_type')->insert([
            'polygon_id' => 1,
            'type_id' => 1,
        ]);

        DB::table('polygon_type')->insert([
            'polygon_id' => 1,
            'type_id' => 2,
        ]);
    }
}
