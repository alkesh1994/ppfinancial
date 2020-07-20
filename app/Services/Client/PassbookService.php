<?php

namespace App\Services\Client;

use Illuminate\Http\Request;
use App\Models\Client\Passbook;
use Carbon\Carbon;

class PassbookService
{

   //process and store data
   public function storePassbook($storeAccount){

     $date = (new Carbon($storeAccount['start_date']))->addMonths(1);

     $storePassbook = Passbook::create([
       'date' => $date,
       'base_amount' => $storeAccount['amount_received'],
       'interest_rate' => $storeAccount['interest_rate'],
       'tenure' => $storeAccount['tenure'],
       'interest_amount' => 0,
       'current_amount' => $storeAccount['amount_received'],
       'total_amount' => $storeAccount['total_amount'],
       'referred_by' => $storeAccount['referred_by'],
       'commission_percentage' => $storeAccount['commission_percentage'],
       'commission_amount' => $storeAccount['commission_amount'],
       'commission_total_amount' => $storeAccount['commission_total_amount'],
       'account_id' => $storeAccount['id']
     ]);

     return $storePassbook;

   }

   //withdraw amount
   public function withdrawAmount(Request $request){

     $lastEntry = Passbook::where('account_id',$request->account_id)->orderBy('created_at','desc')->firstOrFail();

     $penalty = ($request->withdrawn_amount * 20)/100;

     $amountDeducted = $request->withdrawn_amount + $penalty;

     $baseAmount = $lastEntry->base_amount - $amountDeducted;

     $currentAmount = $lastEntry->current_amount - $amountDeducted;

     $interestAmount = ($baseAmount * $lastEntry->interest_rate)/100;

     $commisionAmount = ($baseAmount * $lastEntry->commission_percentage)/100;

     $commisionTotalAmount =  $commisionAmount * $lastEntry->account->tenure;

     $totalAmount = $baseAmount + ($interestAmount * $lastEntry->account->tenure);

     $withdrawnDate = Carbon::now();

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
       'commission_amount'=> $commisionAmount,
       'commission_percentage' => $lastEntry->commission_percentage,
       'commission_period' => $lastEntry->commission_period,
       'commission_total_amount' => $commisionTotalAmount,
       'account_id' => $lastEntry->account_id
     ]);

     return $withdraw;
   }
}
