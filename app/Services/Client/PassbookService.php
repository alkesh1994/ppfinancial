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
