<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class Passbook extends Model
{
    protected $fillable = [
      'date',
      'base_amount',
      'tenure',
      'interest_rate',
      'interest_amount',
      'current_amount',
      'total_amount',
      'withdrawn_amount',
      'withdrawn_date',
      'penalty',
      'referred_by',
      'commission_percentage',
      'commission_amount',
      'commission_total_amount',
      'account_id'
    ];

    public function account(){
      return $this->belongsTo('App\Models\Client\Account');
    }
}
