<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('vendor_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vendor_service')->nullable()->index();
            $table->integer('http_code')->nullable()->nullable();
            $table->longText('data')->nullable()->nullable();
            $table->longText('message')->nullable();
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
        //
        Schema::dropIfExists('vendors_logs');
    }
};
