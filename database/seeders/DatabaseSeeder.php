<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CreatePolygonSeeder::class,
            TypesSeeder::class,
        ]);

         \App\Models\User::factory()->create([
             'name' => 'Admin',
             'email' => 'torhov.s@gmail.com',
             'password' => '$2a$12$1Rnq2BWaiSpeVojWw2nMgOLhnZQu2kpmyChFWRvFALUcgZMGjMU9a',
         ]);
    }
}
