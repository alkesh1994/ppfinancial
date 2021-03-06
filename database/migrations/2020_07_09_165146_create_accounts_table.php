<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->text('slug');
            $table->decimal('amount_received',15,2)->nullable();
            $table->string('tenure')->nullable();
            $table->decimal('interest_rate',3,1)->nullable();
            $table->decimal('interest_amount',15,2)->nullable();
            $table->decimal('total_amount',15,2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('commission_type')->nullable();
            $table->decimal('commission_percentage',3,1)->nullable();
            $table->decimal('commission_amount',15,2)->nullable();
            $table->decimal('commission_total_amount',15,2)->nullable();
            $table->integer('active')->default(1);
            $table->integer('client_id');
            $table->decimal('current_amount',15,2)->nullable();
            $table->date('next_date')->nullable();
            $table->integer('months_left')->nullable();
            $table->decimal('total_withdraw_amount',15,2)->default(0)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('accounts');
    }
}
