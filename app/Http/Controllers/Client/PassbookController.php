<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client\Client;
use App\Models\Client\Account;
use App\Models\Client\Passbook;
use PDF;
use Session;

class PassbookController extends Controller
{

  //To show passbook
  public function show($clientSlug,$accountSlug){

    $client = Client::where('slug',$clientSlug)->firstOrFail();
    $account = Account::where('slug',$accountSlug)->firstOrFail();
    $passbookEntries = Passbook::where('account_id',$account->id)->get();
    $passbookLatest = Passbook::latest('date')->where('account_id',$account->id)->first();
    $passbookOldest = Passbook::oldest('date')->where('account_id',$account->id)->first();

    return view('dashboard.client.account.passbook.show',['account' => $account,'client'=> $client,'passbookEntries'=> $passbookEntries,'passbookLatest'=> $passbookLatest,'passbookOldest'=>$passbookOldest]);

  }

  //export full passbook as pdf
  public function full_passbook_pdf($clientSlug,$accountSlug)
  {
    // Fetch all records from database
    $account = Account::where('slug',$accountSlug)->firstOrFail();
    $passbookEntries = Passbook::where('account_id',$account->id)->get();
    // Send data to the view using loadView function of PDF facade
    $pdf = PDF::loadView('dashboard.client.account.passbook.exportPassbookPdf', ['passbookEntries'=> $passbookEntries]);
    // download the file using download function
    return $pdf->download('full_passbook.pdf');
  }

  //export custom passbook as pdf
  public function custom_passbook_pdf(Request $request,$clientSlug,$accountSlug)
  {
    // Fetch all records from database
    $account = Account::where('slug',$accountSlug)->firstOrFail();
    $passbookEntries = Passbook::where('account_id',$account->id)->whereBetween('date',[$request->from_date,$request->to_date])->get();
    if($passbookEntries->isEmpty())
    {
      Session::flash('success', 'No passbook entries found for the selected date range');
      return redirect()->back();
    }
    // Send data to the view using loadView function of PDF facade
    $pdf = PDF::loadView('dashboard.client.account.passbook.exportPassbookPdf', ['passbookEntries'=> $passbookEntries]);
    // download the file using download function
    return $pdf->download('custom_passbook.pdf');
  }

}
