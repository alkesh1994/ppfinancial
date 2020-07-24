<?php

namespace App\Services\Dashboard;

use App\Services\Client\ClientService;
use App\Services\Client\AccountService;

class DashboardService
{

  private $clientService;
  private $accountService;

  public function __construct(ClientService $clientService,AccountService $accountService)
  {
    $this->clientService = $clientService;
    $this->accountService = $accountService;
  }

  //To fetch dashboard data
  public function dashboardData()
  {

    //fetch total clients
    $totalClients = $this->clientService->totalClients();

    //fetch clients registered this month
    $thisMonthClients = $this->clientService->thisMonthClients();

    //fetch accounts expiring this month
    $thisMonthExpiringAccounts = $this->accountService->thisMonthExpiringAccounts();

    //fetch recent accounts
    $recentAccounts = $this->accountService->recentAccounts();

    //fetch expiring accounts
    $expiringAccounts = $this->accountService->expiringAccounts();

    //fetch elapsing accounts
    $elapsingAccounts = $this->accountService->elapsingAccounts();

    //fetch elapsing commissions
    $elapsingCommissions = $this->accountService->elapsingCommissions();

    return view('home',[
      'totalClients' => $totalClients,
      'thisMonthClients'=> $thisMonthClients,
      'thisMonthExpiringAccounts' => $thisMonthExpiringAccounts,
      'recentAccounts' => $recentAccounts,
      'expiringAccounts' => $expiringAccounts,
      'elapsingAccounts' => $elapsingAccounts,
      'elapsingCommissions' => $elapsingCommissions
    ]);

  }

}
