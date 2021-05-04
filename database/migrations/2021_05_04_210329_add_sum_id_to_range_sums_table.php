<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSumIdToRangeSumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('range_sums', function (Blueprint $table) {
            $table->foreignId('sum_id')->constrained('sums');
            $table->foreignId('range_id')->constrained('ranges');
            $table->dropColumn('sum');
            $table->dropColumn('years');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('range_sums', function (Blueprint $table) {
            $table->double('sum');
            $table->string('years');
        });
    }
}
