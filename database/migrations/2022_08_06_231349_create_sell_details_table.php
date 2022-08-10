<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sell_id');
            $table->foreignId('product_id');
            $table->string('product_code');
            $table->string('product_name');
            $table->decimal('price', $precision=20, $scale=0);
            $table->integer('quantity');
            $table->decimal('diskon', $precision=20, $scale=0);
            $table->decimal('sub_total', $precision=20, $scale=0);
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
        Schema::dropIfExists('sell_details');
    }
}
