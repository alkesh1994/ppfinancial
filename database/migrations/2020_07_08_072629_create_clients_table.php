<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_first_name')->nullable();
            $table->string('client_middle_name')->nullable();
            $table->string('client_last_name')->nullable();
            $table->string('nominee_first_name')->nullable();
            $table->string('nominee_middle_name')->nullable();
            $table->string('nominee_last_name')->nullable();
            $table->date('client_dob')->nullable();
            $table->string('client_phone_number')->nullable();
            $table->string('client_alternate_phone_number')->nullable();
            $table->text('client_permanent_address')->nullable();
            $table->text('client_alternate_address')->nullable();
            $table->text('client_aadhar_card_photo')->nullable();
            $table->text('client_pan_card_photo')->nullable();
            $table->text('client_personal_photo')->nullable();
            $table->string('referred_by')->nullable();
            $table->string('commission_of_referral')->nullable();
            $table->string('client_bank_name')->nullable();
            $table->string('client_bank_account_number')->nullable();
            $table->string('client_bank_ifsc_code')->nullable();
            $table->string('client_bank_micr_code')->nullable();
            $table->string('client_bank_branch')->nullable();
            $table->string('client_bank_cheque_photo')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
