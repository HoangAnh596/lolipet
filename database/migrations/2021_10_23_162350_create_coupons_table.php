<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()    // Đã hoàn thiện
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id'); // xg
            $table->integer('type'); // product -  total product
            $table->string('code'); // xg
            $table->string('details'); // xg
            $table->string('discount'); // chiet khau 
            $table->integer('discount_type'); // xg ( kieu giam gia )
            $table->timestamp('start_date')->nullable(); // xg
            $table->timestamp('end_date')->nullable(); // xg
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
        Schema::dropIfExists('coupons');
    }
}
