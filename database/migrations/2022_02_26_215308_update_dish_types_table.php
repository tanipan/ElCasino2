<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDishTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dish_types', function (Blueprint $table) {

            $table->boolean('manageStock')->default(0);

            $table->boolean('monday')->default(0);
            $table->enum('mondayTurn', ['allDay', 'atMeals', 'atDinners'])->default('allDay');

            $table->boolean('tuesday')->default(0);
            $table->enum('tuesdayTurn', ['allDay', 'atMeals', 'atDinners'])->default('allDay');

            $table->boolean('wednesday')->default(0);
            $table->enum('wednesdayTurn', ['allDay', 'atMeals', 'atDinners'])->default('allDay');

            $table->boolean('thursday')->default(0);
            $table->enum('thursdayTurn', ['allDay', 'atMeals', 'atDinners'])->default('allDay');

            $table->boolean('friday')->default(0);
            $table->enum('fridayTurn', ['allDay', 'atMeals', 'atDinners'])->default('allDay');

            $table->boolean('saturday')->default(0);
            $table->enum('saturdayTurn', ['allDay', 'atMeals', 'atDinners'])->default('allDay');

            $table->boolean('sunday')->default(0);
            $table->enum('sundayTurn', ['allDay', 'atMeals', 'atDinners'])->default('allDay');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dish_types', function (Blueprint $table) {

            $table->dropColumn('manageStock');
            $table->dropColumn('monday');
            $table->dropColumn('mondayTurn');
            $table->dropColumn('tuesday');
            $table->dropColumn('tuesdayTurn');
            $table->dropColumn('wednesday');
            $table->dropColumn('wednesdayTurn');
            $table->dropColumn('thursday');
            $table->dropColumn('thursdayTurn');
            $table->dropColumn('friday');
            $table->dropColumn('fridayTurn');
            $table->dropColumn('saturday');
            $table->dropColumn('saturdayTurn');
            $table->dropColumn('sunday');
            $table->dropColumn('sundayTurn');
        });
    }
}
