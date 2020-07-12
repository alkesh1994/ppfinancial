<?php

namespace App\Services\Client;

use Illuminate\Http\Request;
use App\Models\Client\Passbook;
use Carbon\Carbon;

class PassbookService
{

   //process and store data
   public function storePassbook($storeAccount){

     $nextDate = (new Carbon($storeAccount['start_date']))->addMonths(1);

     $storePassbook = Passbook::create([
       'start_date' => $storeAccount['start_date'],
       'next_date' => $nextDate,
       'end_date' => $storeAccount['end_date'],
       'base_amount' => $storeAccount['amount_received'],
       'interest_rate' => $storeAccount['interest_rate'],
       'interest_amount' => 0,
       'current_amount' => $storeAccount['amount_received'],
       'total_amount' => $storeAccount['total_amount'],
       'months_left' => $storeAccount['tenure'],
       'account_id' => $storeAccount['id']
     ]);

     return $storePassbook;

   }

   //withdraw amount
   public function withdrawAmount(Request $request){

     $lastEntry = Passbook::where('account_id',$request->account_id)->orderBy('created_at','desc')->firstOrFail();

     $baseAmount = $lastEntry->base_amount - $request->withdrawn_amount;

     $currentAmount = $lastEntry->current_amount - $request->withdrawn_amount;

     $interestAmount = ($baseAmount * $lastEntry->interest_rate)/100;

     $totalAmount = $baseAmount + ($interestAmount * $lastEntry->account->tenure);

     $withdrawnDate = Carbon::now();

     $penalty = ($request->withdrawn_amount * 20)/100;

     $withdraw = Passbook::create([
       'start_date' => $lastEntry->start_date,
       'next_date' => $lastEntry->next_date,
       'end_date' => $lastEntry->end_date,
       'base_amount' => $baseAmount,
       'interest_rate' => $lastEntry->interest_rate,
       'interest_amount' => 0,
       'current_amount' => $currentAmount,
       'total_amount' => $totalAmount,
       'months_left' => $lastEntry->months_left,
       'withdrawn_amount' => $request->withdrawn_amount,
       'withdrawn_date' => $withdrawnDate,
       'penalty' => $penalty,
       'account_id' => $lastEntry->account_id
     ]);

     return $withdraw;
   }
}
