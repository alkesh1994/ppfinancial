<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Models\Client\Client;
use App\Services\Client\ClientService;
use Session;


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
      $clientService = new ClientService();
      $storeData = $clientService->storeData($request);

      Session::flash('success', 'Client created successfully');
      return response()->json(['success'=>'Client created successfully.']);

    }
}
