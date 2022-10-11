<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_stats', function (Blueprint $table) {
            $table->id();
            $table->string('symbol', 20);
            $table->float('high', 10, 4);
            $table->float('low', 10, 4);
            $table->float('price', 10, 4);
            $table->timestamps();
            $table->index('symbol');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_stats');
    }
};
