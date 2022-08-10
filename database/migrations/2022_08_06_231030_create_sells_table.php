<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sells', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', $precision=20, $scale=0);
            $table->string('member_name');
            $table->decimal('diskon', $precision=20, $scale=0);
            $table->decimal('bayar', $precision=20, $scale=0);
            $table->decimal('diterima', $precision=20, $scale=0);
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
        Schema::dropIfExists('sells');
    }
}
