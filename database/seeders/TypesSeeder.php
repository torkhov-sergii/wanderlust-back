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
        //all - автозаменяется всеми $types через запятую
        $types = ['all', 'tourist_attraction', 'point_of_interest', 'museum', 'spa', 'park', 'natural_feature'];

        foreach ($types as $type) {
            DB::table('type')->insert([
                'title' => $type,
            ]);
        }

        DB::table('polygon_type')->insert([
            'polygon_id' => 1,
            'type_id' => 1,
        ]);

        DB::table('polygon_type')->insert([
            'polygon_id' => 1,
            'type_id' => 2,
        ]);

//        DB::table('polygon_type')->insert([
//            'polygon_id' => 1,
//            'type_id' => 2,
//        ]);
    }
}
