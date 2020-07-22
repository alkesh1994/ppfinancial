<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Client\StoreAccountRequest;
use App\Services\Client\AccountService;

class AccountController extends Controller
{

    private $accountService;

    public function __construct(AccountService $accountService)
    {
      $this->accountService = $accountService;
    }

    //To show list of accounts
    public function list($slug)
    {

      $listAccounts = $this->accountService->listAccounts($slug);

      return $listAccounts;

    }

    //To store account data in Database
    public function store(StoreAccountRequest $request)
    {

      //account data is valid
      $storeAccount = $this->accountService->storeAccount($request);

      return $storeAccount;

    }

    //to softdelete the account entry
    public function destroy($clientSlug,$accountId)
    {

      $destroyAccount = $this->accountService->destroyAccount($clientSlug,$accountId);

      return $destroyAccount;

    }

    //withdraw amount
    public function withdraw(Request $request)
    {

      $withdrawAccount = $this->accountService->withdrawAccount($request);

      return $withdrawAccount;

    }


}
