<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->integer('location')->nullable();
            $table->boolean('orderWithoutWaiter')->default(false);

            $table->boolean('notify_waiter')->default(false);
            $table->boolean('request_account')->default(false);
            $table->integer('division_account')->default(0);
            $table->string('payment_method')->nullable();

            $table->integer('eaters')->default(0);
            $table->string('status')->nullable();
            $table->string('token')->nullable();

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
        Schema::dropIfExists('redsys');
    }
}
