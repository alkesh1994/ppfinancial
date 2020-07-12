<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreAccountRequest;
use App\Models\Client\Client;
use App\Models\Client\Account;
use App\Services\Client\AccountService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;

class AccountController extends Controller
{
    //To show list of clients
    public function list($slug){

      $client = Client::where('slug',$slug)->firstOrFail();
      $accounts = Account::where('client_id',$client->id)->latest()->get();

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

    //to softdelete the account entry
    public function destroy($clientSlug,$accountId){

      try {
        $account = Account::findOrFail($accountId);
      } catch (ModelNotFoundException $e) {
        Session::flash('success', 'Account is deleted already');
        return redirect()->route('dashboard.clients.accounts.list',['slug'=> $clientSlug]);
      }

        $account->delete();

        Session::flash('success', 'Account deleted successfully');
        return redirect()->route('dashboard.clients.accounts.list',['slug'=> $clientSlug]);

    }


}
