<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client\Client;
use App\Models\Client\Account;
use App\Models\Client\Passbook;

class PassbookController extends Controller
{

  //To show passbook
  public function show($clientSlug,$accountSlug){

    $client = Client::where('slug',$clientSlug)->firstOrFail();
    $account = Account::where('slug',$accountSlug)->firstOrFail();
    $passbookEntries = Passbook::where('account_id',$account->id)->get();

    return view('dashboard.client.account.passbook.show',['account' => $account,'client'=> $client,'passbookEntries'=> $passbookEntries]);

  }
}
