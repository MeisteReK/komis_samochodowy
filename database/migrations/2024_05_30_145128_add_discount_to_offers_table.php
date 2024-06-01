<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountToOffersTable extends Migration
{
    public function up()
{
    Schema::table('offers', function (Blueprint $table) {
        $table->unsignedInteger('discount')->default(0); // dodanie kolumny 'discount'
    });
}

public function down()
{
    Schema::table('offers', function (Blueprint $table) {
        $table->dropColumn('discount'); // usunięcie kolumny 'discount'
    });
}

}

