<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client\Client;
use App\Services\Client\ClientService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;

class ClientController extends Controller
{
    private $clientService;

    public function __construct(ClientService $clientService){
      $this->clientService = $clientService;
    }

    //To show list of clients
    public function list(){

      $clients = Client::latest()->get();

      return view('dashboard.client.list',['clients' => $clients]);

    }

    //To store client data in Database
    public function store(StoreClientRequest $request){

      //client data is valid
      $storeData = $this->clientService->storeData($request);

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
      $updateData = $this->clientService->updateData($request,$id);

      Session::flash('success', 'Client updated successfully');
      return response()->json(['success'=>'Client updated successfully.']);

    }

    //to softdelete the client entry
    public function destroy($id){

      try {
        $client = Client::findOrFail($id);
      } catch (ModelNotFoundException $e) {
        Session::flash('success', 'Client is deleted already');
        return redirect()->route('dashboard.clients.list');
      }

        $client->delete();

        Session::flash('success', 'Client deleted successfully');
        return redirect()->route('dashboard.clients.list');

    }
}
