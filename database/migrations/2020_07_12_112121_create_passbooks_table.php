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
            $table->date('date')->nullable();
            $table->decimal('base_amount',15,4)->nullable();
            $table->decimal('interest_rate',3,1)->nullable();
            $table->integer('tenure')->nullable();
            $table->decimal('interest_amount',15,2)->nullable();
            $table->decimal('current_amount',15,2)->nullable();
            $table->decimal('total_amount',15,2)->nullable();
            $table->decimal('withdrawn_amount',15,2)->default(0)->nullable();
            $table->date('withdrawn_date')->nullable();
            $table->decimal('penalty',15,2)->default(0)->nullable();
            $table->string('referred_by')->nullable();
            $table->decimal('commission_percentage',3,1)->nullable();
            $table->decimal('commission_amount',15,2)->default(0)->nullable();
            $table->decimal('commission_total_amount',15,2)->default(0)->nullable();
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
