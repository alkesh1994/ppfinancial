<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreAccountRequest;
use App\Models\Client\Client;
use App\Models\Client\Account;
use App\Services\Client\AccountService;
use Session;

class AccountController extends Controller
{
    //To show list of clients
    public function list($id){

      $accounts = Account::latest()->get();
      $client = Client::findOrFail($id);

      return view('dashboard.client.account.list',['accounts' => $accounts,'client'=> $client]);

    }
}
