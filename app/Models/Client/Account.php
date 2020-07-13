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
      'total_amount',
      'start_date',
      'end_date',
      'commission_percentage',
      'commission_total_amount',
      'active',
      'client_id'
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

    public function getStatusAttribute()
    {
      if($this->active){
         return 'Active';
      }else{
         return 'Inactive';
      }
    }
}
