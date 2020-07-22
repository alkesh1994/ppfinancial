<?php

namespace App\Console\Commands;

use App\Http\Requests\Client\StoreAccountRequest;
use App\Models\Client\Account;
use App\Services\Client\AccountService;
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
    public function __construct(AccountService $accountService)
    {
        parent::__construct();
        $this->accountService = $accountService;
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
        $todayDate = $todayDate->format('Y-m-d');
        foreach($accs as $acc)
        {
            if($acc->next_date == $todayDate && $acc->months_left != 0)
            {
                $this->accountService->accountCalc($acc->id);                
            }
        }    
    }
    
}
