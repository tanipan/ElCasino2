<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_items', function (Blueprint $table) {
            $table->id();

            $table->string('table_token')->nullable();
            $table->text('item')->nullable();
            $table->string('item_token')->nullable();
            $table->dateTime('add')->nullable();
            $table->dateTime('validated')->nullable();
            $table->dateTime('process')->nullable();
            $table->dateTime('ready')->nullable();
            $table->string('waiter')->nullable();

            $table->timestamps();
            //$table->softDeletes();
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
