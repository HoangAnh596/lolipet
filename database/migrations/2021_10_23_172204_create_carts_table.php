<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id(); // chưa xg
            $table->integer('user_id');
            $table->integer('temp_user_id');
            $table->integer('product_id');
            $table->integer('price');
            $table->integer('shipping_cost');
            $table->integer('shipping_type');
            $table->string('coupond_code');
            $table->integer('coupon_applied');
            $table->integer('quantity');
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
        Schema::dropIfExists('carts');
    }
}
