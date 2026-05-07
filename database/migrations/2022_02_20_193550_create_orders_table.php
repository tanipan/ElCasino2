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

            $table->string('order');
            $table->dateTime('date');
            $table->float('total');
            $table->float('shipping')->nullable();
            $table->string('observacions')->nullable();
            $table->string('delivery_time')->nullable();
            $table->time('time_ready')->nullable();
            $table->integer('margin_ready')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('table')->nullable();
            $table->string('status')->nullable();
            $table->string('status_restaurant')->nullable();
            $table->boolean('paid')->default(0);
            $table->string('observations_canceled')->nullable();
            $table->string('observations_kitchen')->nullable();
            $table->string('order_comoaqui')->nullable();
            $table->string('signature')->nullable();


            /////
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')->references('id')->on('addresses');

            $table->unsignedBigInteger('restaurant_id');
            $table->foreign('restaurant_id')->references('id')->on('restaurants');

            $table->timestamps();
            $table->softDeletes();
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
