<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client\Client;


class ClientController extends Controller
{

    //To show list of clients
    public function list(){

      $clients = Client::orderBy('updated_at','Desc')->get();

      return view('dashboard.client.list')->with('clients',$clients);

    }
}
