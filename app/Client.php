<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
      'client_first_name',
      'client_middle_name',
      'client_last_name',
      'nominee_first_name',
      'nominee_middle_name',
      'nominee_last_name',
      'client_dob',
      'client_phone_number',
      'client_alternate_phone_number',
      'client_permanent_address',
      'client_alternate_address',
      'client_aadhar_card_photo',
      'client_pan_card_photo',
      'client_personal_photo',
      'referred_by',
      'commission_of_referral',
      'client_bank_name',
      'client_bank_account_number',
      'client_bank_ifsc_code',
      'client_bank_micr_code',
      'client_bank_branch',
      'client_cheque_photo',
      'amount_received',
      'tenure',
      'interest_rate',
      'total_amount',
      'commission_percentage',
      'commission_amount',
    ]
}
