<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('shipping_address');
            $table->string('payment_type'); // Hinh thuc thanh toan
            $table->string('payment_status'); // Trang thai thanh toan
            //$table->string('payment_details');
            $table->integer('delivery_status'); // Trang thai giao hang
            $table->integer('grand_total')->nullable(); // Tonng cong
            $table->integer('coupon_discount'); //
            $table->integer('code');
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
        Schema::dropIfExists('orders');
    }
}
