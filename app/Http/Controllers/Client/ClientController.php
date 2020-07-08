<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request\Client\StoreClientRequest;
use App\Models\Client\Client;


class ClientController extends Controller
{

    //To show list of clients
    public function list(){

      $clients = Client::latest()->get();

      return view('dashboard.client.list',['clients' => $clients]);

    }

    //To store client data in Database
    public function store(StoreClientRequest $request){

      //client data is valid

      $this->createCouponService->make($request);

      return back()->with(['success' => 'Congratulations!']);

    }
}
