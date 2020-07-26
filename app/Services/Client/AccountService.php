<?php

namespace App\Services\Client;

use Illuminate\Http\Request;
use App\Http\Requests\Client\StoreAccountRequest;
use App\Models\Client\Client;
use App\Models\Client\Account;
use App\Models\Client\Passbook;
use App\Services\Helpers\SlugService;
use App\Services\Client\PassbookService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;
use Carbon\Carbon;
use PDF;

class AccountService
{

  private $slugService;
  private $passbookService;

  public function __construct(SlugService $slugService,PassbookService $passbookService)
  {
    $this->slugService = $slugService;
    $this->passbookService = $passbookService;
  }

  //To get accounts expiring this month
  public function thisMonthExpiringAccounts($type)
  {

    $today = Carbon::now();

    $thisMonthExpiringAccounts = Account::where('active',1)->whereMonth('end_date',$today)->whereYear('end_date',$today)->get();

    if($type === "view")
    {
      return view('dashboard.client.account.expiringThisMonth',['accounts'=> $thisMonthExpiringAccounts]);
    }else{
      return $thisMonthExpiringAccounts;
    }

  }

  //To get recent accounts
  public function recentAccounts()
  {

    $recentAccounts = Account::latest('start_date')->limit(10)->get();

    return $recentAccounts;

  }

  //To get expiring accounts
  public function expiringAccounts($type)
  {
    if($type === "view")
    {
      $expiringAccounts = Account::where('active',1)->where('months_left',1)->latest()->get();

      return view('dashboard.client.account.expiringAccountsList',['accounts'=>$expiringAccounts]);
    }else{
      $expiringAccounts = Account::where('active',1)->where('months_left',1)->latest()->limit(10)->get();

      return $expiringAccounts;
    }

  }

  //To get elapsing accounts
  public function elapsingAccounts($type)
  {
    $comparableDate = Carbon::now()->addDays(10)->format('Y-m-d');

    $todaysDate = Carbon::now()->format('Y-m-d');

    if($type === "view")
    {
      $elapsingAccounts = Account::where('active',1)->where('next_date','>',$todaysDate)->where('next_date','<=',$comparableDate)->latest()->get();

      return view('dashboard.client.account.elapsingAccountsList',['accounts'=>$elapsingAccounts]);
    }else{
      $elapsingAccounts = Account::where('active',1)->where('next_date','>',$todaysDate)->where('next_date','<=',$comparableDate)->latest()->limit(10)->get();

      return $elapsingAccounts;
    }

  }

  //To get elapsing accounts
  public function elapsingCommissions($type)
  {
    $comparableDate = Carbon::now()->addDays(10)->format('Y-m-d');

    $todaysDate = Carbon::now()->format('Y-m-d');

    if($type === "view")
    {
      $elapsingCommissions = Account::where('active',1)->where('commission_type',1)->where('next_date','>',$todaysDate)->where('next_date','<=',$comparableDate)->latest()->get();

      return view('dashboard.client.account.elapsingCommissionsList',['accounts'=>$elapsingCommissions]);
    }else{
      $elapsingCommissions = Account::where('active',1)->where('commission_type',1)->where('next_date','>',$todaysDate)->where('next_date','<=',$comparableDate)->latest()->limit(10)->get();

      return $elapsingCommissions;
    }

  }

  //To show list of accounts
  public function listAccounts($slug)
  {

    $client = Client::where('slug',$slug)->firstOrFail();
    $accounts = Account::where('client_id',$client->id)->latest()->get();

    return view('dashboard.client.account.list',['accounts' => $accounts,'client'=> $client]);

  }

  //process and store data
  public function storeAccount(StoreAccountRequest $request)
  {

    $slug = $this->slugService->createSlug('Client\\Account',str_random(10));

    $startDate = (new Carbon($request->get('start_date')));
    $endDate = (new Carbon($request->get('start_date')))->addMonths($request->input('tenure'));
    $nextDate = (new Carbon($request->get('start_date')))->addMonths(1);
    $referredBy = $request->referred_by;

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

    $storePassbook = $this->passbookService->storePassbook($storeAccount,$referredBy);

    Session::flash('success', 'Account created successfully');
    return response()->json(['success'=>'Account created successfully.']);

  }

  //to softdelete the account entry
  public function destroyAccount($clientSlug,$accountId)
  {

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

  //withdraw amount
  public function withdrawAccount(Request $request)
  {

    $lastEntry = Passbook::where('account_id',$request->account_id)->orderBy('created_at','desc')->firstOrFail();

    $penalty = ($request->withdrawn_amount * 20)/100;

    $amountDeducted = $request->withdrawn_amount + $penalty;

    $currentAmount = $lastEntry->current_amount - $amountDeducted;

    $interestAmount = ($currentAmount * $lastEntry->interest_rate)/100;

    $totalAmount = $currentAmount + ($interestAmount * $lastEntry->account->tenure);

    $withdrawnDate = Carbon::now();

    $withdraw = Passbook::create([
      'date' => $withdrawnDate,
      'base_amount' => $lastEntry->base_amount,
      'tenure' => $lastEntry->tenure,
      'interest_rate' => $lastEntry->interest_rate,
      'interest_amount' => $interestAmount,
      'current_amount' => $currentAmount,
      'total_amount' => $totalAmount,
      'months_left' => $lastEntry->months_left,
      'withdrawn_amount' => $request->withdrawn_amount,
      'withdrawn_date' => $withdrawnDate,
      'penalty' => $penalty,
      'referred_by' => $lastEntry->referred_by,
      'commission_type'=> $lastEntry->commission_type,
      'commission_amount'=> $lastEntry->commission_amount,
      'commission_percentage' => $lastEntry->commission_percentage,
      'commission_total_amount' => $lastEntry->commission_total_amount,
      'account_id' => $lastEntry->account_id
    ]);

    $account = Account::findOrFail($lastEntry->account_id);

    $account->current_amount = $currentAmount;
    $account->interest_amount = $interestAmount;
    $account->total_amount = $totalAmount;
    $account->total_withdraw_amount = $account->total_withdraw_amount + $request->withdrawn_amount;

    $account->save();

    Session::flash('success', 'Amount withdrawn successfully');
    return redirect()->back();

  }

  public function accountCalc($id)
  {

    $account = Account::find($id);
    $nextDate = Carbon::now()->addMonths(1);
    $monthsLeft = $account->months_left - 1;
    $currentAmount = $account->current_amount + $account->interest_amount;

    if($monthsLeft)
    {
      $account->active = 1;
    }else{
      $account->active = 0;
    }

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
      'commission_type'=> $account->commission_type,
      'commission_percentage' => $account->commission_percentage,
      'commission_amount' => $account->commission_amount,
      'commission_total_amount' => $account->commission_total_amount,
      'account_id' => $account->id
    ]);

  }

  //export accounts report as pdf
  public function exportPdf($clientSlug)
  {
    // Fetch all records from database
    $client = Client::where('slug',$clientSlug)->firstOrFail();

    $accounts = Account::where('client_id',$client->id)->get();

    if($accounts->isEmpty())
    {
      Session::flash('success', 'No accounts exist for this client');
      return redirect()->back();
    }

    // Send data to the view using loadView function of PDF facade
    $pdf = PDF::loadView('dashboard.client.account.exportAccountsPdf', ['client'=>$client,'accounts'=>$accounts]);
    // download the file using download function
    return $pdf->download('accounts.pdf');
  }

}
