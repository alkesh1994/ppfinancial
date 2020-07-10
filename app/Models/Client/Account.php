<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
      'amount_received',
      'tenure',
      'interest_rate',
      'total_amount',
      'start_date',
      'end_date',
      'commission_percentage',
      'commission_amount',
      'active',
      'client_id'
    ];

    public function client(){
      return $this->belongsTo('App\Models\Client\Client')->withTrashed();
    }

    public function getTenureDisplayAttribute()
    {
      if($this->tenure == 6)
         return '6 months';

      if($this->tenure == 12)
        return '1 year';
    }
}
