<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->timestamps();
        });

        Schema::create('polygon_type', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('polygon_id')->index();
            $table->unsignedBigInteger('type_id')->index();
            $table->boolean('done')->default(0);
            $table->longText('message')->nullable();
            $table->timestamps();
        });

        Schema::table('polygon_type', function(Blueprint $table) {
            $table->foreign('polygon_id')
                ->references('id')
                ->on('polygon')
                ->onDelete('cascade');
        });

        Schema::table('polygon_type', function(Blueprint $table) {
            $table->foreign('type_id')
                ->references('id')
                ->on('type')
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
        Schema::dropIfExists('type');
    }
}
