<?php

namespace App\Console\Commands;

use App\Http\Requests\Client\StoreAccountRequest;
use App\Models\Client\Account;
use App\Services\Helpers\SlugService;
use App\Models\Client\Passbook;
use Carbon\Carbon;

use Illuminate\Console\Command;

class UpdatePassbook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:passbook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new entry in passbook';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {   
        $accs = Account::all();
        $todayDate = Carbon::now();
        foreach($accs as $acc)
        {
            if($acc->next_date == $todayDate && $acc->months_left!= 0)
            {
                if($acc->commission_type == 1 || $acc->commission_type == 0){
                    $account = Account::find($acc->id);
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
                        'commission_total_amount' => $account->commission_total_amount,
                        'account_id' => $account->id
                    ]);
                }

                if($acc->commission_type == 2 || $acc->commission_type == 0){
                    $account = Account::find($acc->id);
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
        }    
    }
}
