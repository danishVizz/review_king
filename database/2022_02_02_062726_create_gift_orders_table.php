<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('order_number')->default(0);
            $table->text('order_desc')->nullable();
            $table->tinyInteger('status')->default(0)->comment('1=active, 0=deactive');
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
        Schema::dropIfExists('gift_orders');
    }
}