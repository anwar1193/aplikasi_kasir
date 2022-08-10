<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buy_id');
            $table->foreignId('product_id');
            $table->string('product_name');
            $table->decimal('price', $precision=11, $scale=0);
            $table->integer('quantity');
            $table->decimal('sub_total', $precision=11, $scale=0);
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
        Schema::dropIfExists('buy_details');
    }
}
