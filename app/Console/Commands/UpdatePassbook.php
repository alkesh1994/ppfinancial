<?php

namespace App\Console\Commands;

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
        //
    }
}
