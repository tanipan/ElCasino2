<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->string('img')->nullable();
            $table->float('minimum_purchase')->default(0);
            $table->boolean('hidden')->default(0);
            $table->integer('delivery_time')->default(0);
            $table->float('shipping_amount')->default(0);
            $table->float('benefit_ticket')->default(0);
            $table->float('quota')->default(0);
            $table->string('status')->nullable();
            $table->string('slug')->nullable();
            $table->string('minimal_slug')->nullable();
            $table->string('user')->nullable();
            $table->string('pass')->nullable();
            $table->string('token')->nullable();
            $table->boolean('delivery')->default(0);
            $table->boolean('take_away')->default(0);
            $table->boolean('manage_menu')->default(0);
            $table->boolean('manage_orders')->default(0);
            $table->boolean('report')->default(0);
            $table->boolean('manage_tablet')->default(0);

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
        Schema::dropIfExists('restaurants');
    }
}
