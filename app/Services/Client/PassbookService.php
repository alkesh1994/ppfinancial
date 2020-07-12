<?php

namespace App\Services\Client;

use App\Models\Client\Passbook;
use Carbon\Carbon;

class PassbookService
{

   //process and store data
   public function storePassbook($storeAccount){

     $nextDate = (new Carbon($storeAccount['start_date']))->addMonths(1);

     $interestAmount = ($storeAccount['amount_received'] * $storeAccount['interest_rate']) / 100;

     $storePassbook = Passbook::create([
       'start_date' => $storeAccount['start_date'],
       'next_date' => $nextDate,
       'end_date' => $storeAccount['end_date'],
       'base_amount' => $storeAccount['amount_received'],
       'interest_rate' => $storeAccount['interest_rate'],
       'interest_amount' => $interestAmount,
       'total_amount' => $storeAccount['total_amount'],
       'months_left' => $storeAccount['tenure'],
       'account_id' => $storeAccount['id']
     ]);

     return $storePassbook;

   }
}
