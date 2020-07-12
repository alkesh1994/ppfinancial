<?php

namespace App\Services\Client;

use App\Http\Requests\Client\StoreAccountRequest;
use App\Models\Client\Account;
use App\Services\Helpers\SlugService;
use Carbon\Carbon;

class AccountService
{

   private $slugService;

   public function __construct(SlugService $slugService){
     $this->slugService = $slugService;
   }

   //process and store data
   public function storeData(StoreAccountRequest $request){

     $slug = $this->slugService->createSlug('Client\\Account',str_random(10));

     $startDate = (new Carbon($request->get('start_date')));
     $endDate = (new Carbon($request->get('start_date')))->addMonths($request->input('tenure'));

     $storeData = Account::create([
       'slug' => $slug,
       'amount_received' => $request->get('amount_received'),
       'tenure' => $request->get('tenure'),
       'interest_rate' => $request->get('interest_rate'),
       'total_amount' => $request->get('total_amount'),
       'start_date' => $startDate,
       'end_date' => $endDate,
       'commission_percentage' => $request->get('commission_percentage'),
       'commission_amount' => $request->get('commission_amount'),
       'client_id' => $request->get('client_id')
     ]);

     return $storeData;

   }
}
