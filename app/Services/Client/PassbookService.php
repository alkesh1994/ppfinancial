<?php

namespace App\Services\Client;

use Illuminate\Http\Request;
use App\Models\Client\Passbook;
use App\Models\Client\Account;
use App\Models\Client\Client;
use Carbon\Carbon;
use PDF;
use Session;

class PassbookService
{

   //to show passbook
   public function showPassbook($clientSlug,$accountSlug){

     $client = Client::where('slug',$clientSlug)->firstOrFail();
     $account = Account::where('slug',$accountSlug)->firstOrFail();
     $passbookEntries = Passbook::where('account_id',$account->id)->get();
     $passbookLatest = Passbook::latest('date')->where('account_id',$account->id)->first();
     $passbookOldest = Passbook::oldest('date')->where('account_id',$account->id)->first();

     return view('dashboard.client.account.passbook.show',['account' => $account,'client'=> $client,'passbookEntries'=> $passbookEntries,'passbookLatest'=> $passbookLatest,'passbookOldest'=>$passbookOldest]);
   }

   //process and store data
   public function storePassbook($storeAccount)
   {

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
   public function withdrawAmount(Request $request)
   {

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
       'commission_type'=> $lastEntry->commission_type,
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

   //export passbook report as pdf
   public function exportPdf(Request $request,$clientSlug,$accountSlug)
   {
     // Fetch all records from database
     $client = Client::where('slug',$clientSlug)->firstOrFail();

     $account = Account::where('slug',$accountSlug)->firstOrFail();

     if($request->filled('from_date') && $request->filled('to_date'))
     {
       $passbookEntries = Passbook::where('account_id',$account->id)->whereBetween('date',[$request->from_date,$request->to_date])->get();
       $fromDate = Carbon::parse($request->from_date)->format('j F Y');
       $toDate = Carbon::parse($request->to_date)->format('j F Y');
       $reportRange = "From ".$fromDate." to ".$toDate;
     }else{
       $passbookEntries = Passbook::where('account_id',$account->id)->get();
       $reportRange = "Full Report";
     }

     if($passbookEntries->isEmpty())
     {
       Session::flash('success', 'No passbook entries found for the selected date range');
       return redirect()->back();
     }

     // Send data to the view using loadView function of PDF facade
     if($request->report_type === "Customer Report"){
       $pdf = PDF::loadView('dashboard.client.account.passbook.exportCustomerPassbookPdf', ['passbookEntries'=> $passbookEntries,'reportType'=> $request->report_type,'reportRange'=> $reportRange,'client'=>$client,'account'=>$account]);
       // download the file using download function
       return $pdf->download('customer-passbook.pdf');
     }else{
       $pdf = PDF::loadView('dashboard.client.account.passbook.exportReferralPassbookPdf', ['passbookEntries'=> $passbookEntries,'reportType'=> $request->report_type,'reportRange'=> $reportRange,'client'=>$client,'account'=>$account]);
       // download the file using download function
       return $pdf->download('referral-passbook.pdf');
     }
   }
}
