<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Services\Client\ClientService;


class ClientController extends Controller
{
    private $clientService;

    public function __construct(ClientService $clientService)
    {
      $this->clientService = $clientService;
    }

    //To show list of clients
    public function list()
    {

      $listClients = $this->clientService->listClients();

      return $listClients;

    }

    //To store client data in Database
    public function store(StoreClientRequest $request)
    {

      //client data is valid
      $storeClient = $this->clientService->storeClient($request);

      return $storeClient;

    }

    //to show edit form
    public function edit($slug)
    {

      $editClient = $this->clientService->editClient($slug);

      return $editClient;

    }

    //To update client data in Database
    public function update(UpdateClientRequest $request,$id)
    {

      //client data is valid
      $updateClient = $this->clientService->updateClient($request,$id);

      return $updateClient;

    }

    //to softdelete the client entry
    public function destroy($id)
    {

      $destroyClient = $this->clientService->destroyClient($id);

      return $destroyClient;

    }
}
