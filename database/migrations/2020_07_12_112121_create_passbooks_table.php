<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passbooks', function (Blueprint $table) {
            $table->id();
            $table->date('start_date')->nullable();
            $table->date('next_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('base_amount')->nullable();
            $table->integer('interest_rate')->nullable();
            $table->integer('interest_amount')->nullable();
            $table->integer('current_amount')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('months_left')->nullable();
            $table->integer('withdrawn_amount')->nullable();
            $table->date('withdrawn_date')->nullable();
            $table->integer('penalty')->nullable();
            $table->integer('account_id');
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
        Schema::dropIfExists('passbooks');
    }
}
