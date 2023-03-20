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
        // https://developers.google.com/maps/documentation/places/web-service/supported_types

        //all - автозаменяется всеми $types через запятую
        //point_of_interest - возможно убрать, но тогда будут пропуски, например замок возле нас
//        $types = ['point_of_interest', 'tourist_attraction', 'museum', 'spa', 'park', 'natural_feature'];
        $types = ['tourist_attraction', 'museum', 'park', 'natural_feature','point_of_interest'];

        foreach ($types as $type) {
            DB::table('type')->insert([
                'title' => $type,
            ]);

            DB::table('polygon_type')->insert([
                'polygon_id' => 1,
                'type_id' => DB::getPdo()->lastInsertId(),
            ]);
        }

//        DB::table('polygon_type')->insert([
//            'polygon_id' => 1,
//            'type_id' => 1,
//        ]);
//
//        DB::table('polygon_type')->insert([
//            'polygon_id' => 1,
//            'type_id' => 2,
//        ]);
    }
}
