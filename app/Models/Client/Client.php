<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use SoftDeletes;
    use Notifiable;

    protected $fillable = [
      'slug',
      'client_first_name',
      'client_middle_name',
      'client_last_name',
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
      'client_bank_cheque_photo',
    ];

    protected $dates = ['deleted_at'];

    public function accounts()
    {
      return $this->hasMany('App\Models\Client\Account');
    }

    public function getClientFullNameAttribute()
    {
      return $this->client_first_name . ' ' . $this->client_middle_name . ' ' . $this->client_last_name;
    }

    public function routeNotificationForNexmo($notification)
    {
      return $this->client_phone_number;
    }


}
