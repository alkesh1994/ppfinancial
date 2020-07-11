<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
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

    //to sho edit form
    public function edit($slug){

      $client = Client::where('slug',$slug)->firstOrFail();

      return view('dashboard.client.edit',['client' => $client]);

    }

    //To update client data in Database
    public function update(UpdateClientRequest $request,$id){

      //client data is valid
      $clientService = new ClientService();
      $updateData = $clientService->updateData($request,$id);

      Session::flash('success', 'Client updated successfully');
      return response()->json(['success'=>'Client updated successfully.']);

    }

    //to softdelete the client entry
    public function destroy($id){

      $client = Client::findOrFail($id);

      $client->delete();

      Session::flash('success', 'Client deleted successfully');
      return redirect()->route('dashboard.clients.list');

    }
}
