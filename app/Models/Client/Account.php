<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'slug',
      'amount_received',
      'tenure',
      'interest_rate',
      'interest_amount',
      'total_amount',
      'start_date',
      'end_date',
      'commission_type',
      'commission_percentage',
      'commission_amount',
      'commission_total_amount',
      'active',
      'client_id',
      'current_amount',
      'next_date',
      'months_left',
      'total_withdraw_amount'
    ];

    protected $dates = ['deleted_at'];

    public function client(){
      return $this->belongsTo('App\Models\Client\Client')->withTrashed();
    }

    public function passbook(){
      return $this->hasOne('App\Models\Client\Passbook');
    }

    public function getTenureDisplayAttribute()
    {
      if($this->tenure == 6)
         return '6 months';

      if($this->tenure == 12)
        return '1 year';
    }

    public function getCommissionTypeDisplayAttribute()
    {
      if($this->commission_type == 0)
         return 'N.A';

      if($this->commission_type == 1)
         return 'Monthly';

      if($this->commission_type == 2)
        return 'One Time';
    }

    public function getStatusAttribute()
    {
      if($this->active){
         return 'Active';
      }else{
         return 'Inactive';
      }
    }
}
