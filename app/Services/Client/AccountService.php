<?php

namespace App\Services\Client;

use Illuminate\Http\Request;
use App\Http\Requests\Client\StoreAccountRequest;
use App\Models\Client\Account;
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

     $storeAccount = Account::create([
       'slug' => $slug,
       'amount_received' => $request->get('amount_received'),
       'tenure' => $request->get('tenure'),
       'interest_rate' => $request->get('interest_rate'),
       'total_amount' => $request->get('total_amount'),
       'start_date' => $startDate,
       'end_date' => $endDate,
       'commission_percentage' => $request->get('commission_percentage'),
       'commission_total_amount' => $request->get('commission_total_amount'),
       'client_id' => $request->get('client_id')
     ]);

     $storePassbook = $this->passbookService->storePassbook($storeAccount);

     return $storeAccount;

   }

   //withdraw amount
   public function withdrawAmount(Request $request){

     $withdraw = $this->passbookService->withdrawAmount($request);

     return $withdraw;
   }


}
