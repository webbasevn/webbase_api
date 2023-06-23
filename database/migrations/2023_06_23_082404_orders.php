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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id');
            $table->bigInteger('customer_id');
            $table->bigInteger('total');
            $table->string('status');
            $table->string('payment_type');
            $table->string('payment_status');
            $table->longText('shipping_address');
            $table->integer('shipping_city_id');
            $table->integer('shipping_ditrict_id');
            $table->integer('shipping_ward_id');
            $table->string('shipping_method');
            $table->bigInteger('shipping_fee');
            $table->string('shipping_code'); // kênh ship : GHN, GHTK
            $table->string('shipping_status');
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
};
