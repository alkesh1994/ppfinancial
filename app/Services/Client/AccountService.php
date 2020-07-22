<?php

namespace App\Services\Client;

use Illuminate\Http\Request;
use App\Http\Requests\Client\StoreAccountRequest;
use App\Models\Client\Account;
use App\Models\Client\Passbook;
use App\Services\Helpers\SlugService;
use App\Services\Client\PassbookService;
use Carbon\Carbon;

class AccountService
{

   private $slugService;
   private $passbookService;

   public function __construct(SlugService $slugService,PassbookService $passbookService){
     $this->slugService = $slugService;
     $this->passbookService = $passbookService;
   }

   //process and store data
   public function storeData(StoreAccountRequest $request){

     $slug = $this->slugService->createSlug('Client\\Account',str_random(10));

     $startDate = (new Carbon($request->get('start_date')));
     $endDate = (new Carbon($request->get('start_date')))->addMonths($request->input('tenure'));
     $nextDate = (new Carbon($request->get('next_date')))->addMonths(1);

     $storeAccount = Account::create([
       'slug' => $slug,
       'amount_received' => $request->get('amount_received'),
       'tenure' => $request->get('tenure'),
       'interest_rate' => $request->get('interest_rate'),
       'interest_amount' => $request->get('interest_amount'),
       'total_amount' => $request->get('total_amount'),
       'start_date' => $startDate,
       'end_date' => $endDate,
       'commission_type' => $request->get('commission_type'),
       'commission_percentage' => $request->get('commission_percentage'),
       'commission_amount' => $request->get('commission_amount'),
       'commission_total_amount' => $request->get('commission_total_amount'),
       'client_id' => $request->get('client_id'),
       'current_amount'=> $request->get('amount_received'),
       'next_date' => $nextDate,
       'months_left' => $request->get('tenure')
     ]);

     $storePassbook = $this->passbookService->storePassbook($storeAccount);

     return $storeAccount;

   }

   //withdraw amount
   public function withdrawAmount(Request $request){

     $withdraw = $this->passbookService->withdrawAmount($request);

     return $withdraw;
   }

   public function accountCalc($id) {
    $account = Account::find($id);
    $nextDate = Carbon::now()->addMonths(1);
    $monthsLeft = $account->months_left - 1;
    $currentAmount = $account->current_amount + $account->interest_amount;

    //For account 
    $account->next_date = $nextDate;
    $account->months_left = $monthsLeft;
    $account->current_amount = $currentAmount;
    $account->save();
    //passbook

    $storePassbook = Passbook::create([
        'date' => Carbon::now(),
        'base_amount' => $account->amount_received,
        'interest_rate' => $account->interest_rate,
        'tenure' => $account->tenure,
        'interest_amount' => $account->interest_amount,
        'current_amount' => $currentAmount,
        'total_amount' => $account->total_amount,
        'referred_by' => $account->referred_by,
        'commission_percentage' => $account->commission_percentage,
        'commission_amount' => $account->commission_amount,
        'commission_total_amount' => $account->commission_amount,
        'account_id' => $account->id
    ]);

}


}
