<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('category_id');
            $table->integer('color_id')->nullable();
            $table->integer('user_id');
            $table->string('slug');
            $table->string('image');
            $table->double('rating')->default(0); // Xep hang
            $table->integer('price')->default(0);

            $table->integer('coupon_id')->nullable();

            $table->integer('discount')->nullable(); // Chiết khẩu
            $table->integer('discount_type')->nullable(); // Chiết khấu & %
            $table->integer('min_quantity')->nullable(); // Xem xét xóa
            $table->timestamp('discount_start_date')->nullable();
            $table->timestamp('discount_end_date')->nullable();

            $table->integer('status')->default(1);
            $table->integer('quantity')->default(0);
            $table->text('detail')->nullable();
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
        Schema::dropIfExists('accessories');
    }
}
