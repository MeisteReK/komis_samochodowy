<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarSpecificationsTable extends Migration
{
    public function up()
    {
        Schema::create('car_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
            $table->string('engine');
            $table->string('transmission');
            $table->string('color');
            $table->integer('year');
            $table->integer('mileage');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('car_specifications');
    }
}
