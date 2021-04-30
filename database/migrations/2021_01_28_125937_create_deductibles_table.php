<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeductiblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deductibles', function (Blueprint $table) {
            $table->id();
            $table->double('option', 16, 2);
            $table->float('applicable', 4, 2);
            $table->boolean('is_saving')->default(1);
            $table->foreignId('detail_id')->constrained('details');
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
        Schema::dropIfExists('deductibles');
    }
}
