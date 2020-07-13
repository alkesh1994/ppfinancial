<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class Passbook extends Model
{
    protected $fillable = [
      'start_date',
      'next_date',
      'end_date',
      'base_amount',
      'interest_rate',
      'interest_amount',
      'current_amount',
      'total_amount',
      'months_left',
      'withdrawn_amount',
      'withdrawn_date',
      'penalty',
      'commission_percentage',
      'commission_amount',
      'commission_total_amount',
      'account_id'
    ];

    public function account(){
      return $this->belongsTo('App\Models\Client\Account');
    }
}