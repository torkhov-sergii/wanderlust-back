<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolygonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polygon', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('root_polygon_id')->nullable()->index();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->string('title')->nullable();
            $table->integer('depth')->nullable()->default(0);
            $table->decimal('lat', 10, 7);
            $table->decimal('lon', 10, 7);
            $table->integer('radius');
            $table->integer('disabled')->default(0)->index();
            //$table->text('message')->nullable();
            $table->timestamps();
        });

        Schema::table('polygon', function(Blueprint $table) {
            $table->foreign('parent_id')
                ->references('id')
                ->on('polygon')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('polygon');
    }
}
