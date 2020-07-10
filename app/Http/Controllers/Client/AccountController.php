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

      $accounts = Account::where('client_id',$id)->latest()->get();
      $client = Client::findOrFail($id);

      return view('dashboard.client.account.list',['accounts' => $accounts,'client'=> $client]);

    }

    //To store account data in Database
    public function store(StoreAccountRequest $request){

      //account data is valid
      $accountService = new AccountService();
      $storeData = $accountService->storeData($request);

      Session::flash('success', 'Account created successfully');
      return response()->json(['success'=>'Account created successfully.']);

    }
}
