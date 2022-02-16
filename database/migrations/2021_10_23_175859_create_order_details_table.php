<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('product_id');
            $table->integer('price')->default(0);
            $table->double('tax',20, 0)->default(0); // Thue
            $table->integer('shipping_cost')->default(0); // Gia van chuyen
            $table->integer('shipping_type')->default(0); // Kieu van chuyen
            $table->string('payment_status'); // Tinh trang thanh toan
            $table->string('delivery_status'); // Tinh trang giao hang
            $table->integer('quantity');
            // Chua hoan thien
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
        Schema::dropIfExists('order_details');
    }
}
