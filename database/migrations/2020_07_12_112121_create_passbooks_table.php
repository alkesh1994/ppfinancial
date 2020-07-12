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
            $table->integer('base_amount');
            $table->integer('interest_amount');
            $table->integer('total_amount');
            $table->integer('withdrawn_amount');
            $table->integer('penalty');
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
