<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Client\StoreAccountRequest;
use App\Models\Client\Client;
use App\Models\Client\Account;
use App\Services\Client\AccountService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;

class AccountController extends Controller
{

    private $accountService;

    public function __construct(AccountService $accountService){
      $this->accountService = $accountService;
    }

    //To show list of clients
    public function list($slug){

      $client = Client::where('slug',$slug)->firstOrFail();
      $accounts = Account::where('client_id',$client->id)->latest()->get();

      return view('dashboard.client.account.list',['accounts' => $accounts,'client'=> $client]);

    }

    //To store account data in Database
    public function store(StoreAccountRequest $request){

      //account data is valid
      $storeData = $this->accountService->storeData($request);

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

    //when amount is withdrawn
    public function withdraw(Request $request){

      //get result
      $withdraw = $this->accountService->withdrawAmount($request);

      Session::flash('success', 'Amount withdrawn successfully');
      return response()->json(['success'=>'Account withdrawn successfully.']);

    }


}
