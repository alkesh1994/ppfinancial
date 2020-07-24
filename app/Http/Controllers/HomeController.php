<?php

namespace App\Http\Controllers;

use App\Services\Dashboard\DashboardService;

class HomeController extends Controller
{
     private $dashboardService;

     public function __construct(DashboardService $dashboardService)
     {
       $this->middleware('auth');
       $this->dashboardService = $dashboardService;
     }

     //to fetch dashboard data
     public function dashboard()
     {
       $dashboardData = $this->dashboardService->dashboardData();

       return $dashboardData;
     }
}
