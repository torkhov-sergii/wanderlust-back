<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place', function (Blueprint $table) {
            $table->id();
            $table->integer('root_polygon_id')->index();
            $table->integer('polygon_type_id')->index();
            $table->integer('polygon_id')->index();
            $table->string('title')->nullable();
            $table->decimal('rating', 4, 2)->nullable()->default(0)->index();
            $table->integer('ratings_total')->nullable()->default(0)->index();
            $table->integer('user_rating')->nullable()->default(0)->index();
            $table->string('place_id')->nullable()->index();
            $table->json('types')->nullable();
            $table->decimal('lat', 10, 7);
            $table->decimal('lon', 10, 7);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('place');
    }
}
