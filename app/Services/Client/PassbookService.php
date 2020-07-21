<?php

namespace App\Services\Client;

use Illuminate\Http\Request;
use App\Models\Client\Passbook;
use App\Models\Client\Account;
use Carbon\Carbon;

class PassbookService
{

   //process and store data
   public function storePassbook($storeAccount){

     $storePassbook = Passbook::create([
       'date' => $storeAccount['start_date'],
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

     $currentAmount = $lastEntry->current_amount - $amountDeducted;

     $interestAmount = ($currentAmount * $lastEntry->interest_rate)/100;

     $totalAmount = $currentAmount + ($interestAmount * $lastEntry->account->tenure);

     $withdrawnDate = Carbon::now();

     $withdraw = Passbook::create([
       'date' => $withdrawnDate,
       'base_amount' => $lastEntry->base_amount,
       'tenure' => $lastEntry->tenure,
       'interest_rate' => $lastEntry->interest_rate,
       'interest_amount' => $interestAmount,
       'current_amount' => $currentAmount,
       'total_amount' => $totalAmount,
       'months_left' => $lastEntry->months_left,
       'withdrawn_amount' => $request->withdrawn_amount,
       'withdrawn_date' => $withdrawnDate,
       'penalty' => $penalty,
       'referred_by' => $lastEntry->referred_by,
       'commission_amount'=> $lastEntry->commission_amount,
       'commission_percentage' => $lastEntry->commission_percentage,
       'commission_total_amount' => $lastEntry->commission_total_amount,
       'account_id' => $lastEntry->account_id
     ]);

     $account = Account::findOrFail($lastEntry->account_id);

     $account->current_amount = $currentAmount;
     $account->interest_amount = $interestAmount;
     $account->total_amount = $totalAmount;
     $account->total_withdraw_amount = $account->total_withdraw_amount + $request->withdrawn_amount;

     $account->save();

     return $withdraw;
   }
}
