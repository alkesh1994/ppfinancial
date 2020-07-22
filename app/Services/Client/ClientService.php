<?php

namespace App\Services\Client;

use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client\Client;
use App\Services\Helpers\SlugService;
use App\Services\Helpers\ImageUploadService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;

class ClientService
{
   private $slugService;
   private $imageUploadService;

   public function __construct(SlugService $slugService,ImageUploadService $imageUploadService)
   {
     $this->slugService = $slugService;
     $this->imageUploadService = $imageUploadService;
   }

   //To show list of clients
   public function listClients()
   {

     $clients = Client::latest()->get();

     return view('dashboard.client.list',['clients' => $clients]);

   }

   //process and store data
   public function storeClient(StoreClientRequest $request)
   {

     $sluggableField = $request->get('client_first_name').' '.$request->get('client_middle_name').' '.$request->get('client_last_name').' '.str_random(10);
     $slug = $this->slugService->createSlug('Client\\Client',$sluggableField);

     $clientAadharCardPhotoPath = $this->imageUploadService->handleImageUpload($request->file('client_aadhar_card_photo'),'clients/aadharCards');

     $clientPanCardPhotoPath = $this->imageUploadService->handleImageUpload($request->file('client_pan_card_photo'),'clients/panCards');

     $clientPersonalPhotoPath = $this->imageUploadService->handleImageUpload($request->file('client_personal_photo'),'clients/personalPhotos');

     $clientBankChequePhotoPath = $this->imageUploadService->handleImageUpload($request->file('client_bank_cheque_photo'),'clients/bankCheques');

     $storeData = Client::create([
       'slug' => $slug,
       'client_first_name' => $request->get('client_first_name'),
       'client_middle_name' => $request->get('client_middle_name'),
       'client_last_name' => $request->get('client_last_name'),
       'client_dob' => $request->get('client_dob'),
       'client_phone_number' => $request->get('client_phone_number'),
       'client_alternate_phone_number' => $request->get('client_alternate_phone_number'),
       'referred_by' => $request->get('referred_by'),
       'commission_of_referral' => $request->get('commission_of_referral'),
       'client_permanent_address' => $request->get('client_permanent_address'),
       'client_alternate_address' => $request->get('client_alternate_address'),
       'client_aadhar_card_photo' => $clientAadharCardPhotoPath,
       'client_pan_card_photo' => $clientPanCardPhotoPath,
       'client_personal_photo' => $clientPersonalPhotoPath,
       'client_bank_name' => $request->get('client_bank_name'),
       'client_bank_branch' => $request->get('client_bank_branch'),
       'client_bank_ifsc_code' => $request->get('client_bank_ifsc_code'),
       'client_bank_micr_code' => $request->get('client_bank_micr_code'),
       'client_bank_account_number' => $request->get('client_bank_account_number'),
       'client_bank_cheque_photo' => $clientBankChequePhotoPath
     ]);

     Session::flash('success', 'Client created successfully');
     return response()->json(['success'=>'Client created successfully.']);

   }

   //to show edit form
   public function editClient($slug)
   {

     $client = Client::where('slug',$slug)->firstOrFail();

     return view('dashboard.client.edit',['client' => $client]);

   }

   //process and update data
   public function updateClient(UpdateClientRequest $request,$id)
   {

     $client = Client::findOrFail($id);

     if(($client->client_first_name != $request->client_first_name) || ($client->client_middle_name != $request->client_middle_name) || ($client->client_last_name != $request->client_last_name)){
       $sluggableField = $request->get('client_first_name').' '.$request->get('client_middle_name').' '.$request->get('client_last_name').' '.str_random(10);
       $client->slug = $this->slugService->createSlug('Client\\Client',$sluggableField);
     }else{
       $slug = $client->slug;
     }

     if($request->file('client_aadhar_card_photo'))
     $client->client_aadhar_card_photo = $this->imageUploadService->handleImageUpload($request->file('client_aadhar_card_photo'),'clients/aadharCards',$client->client_aadhar_card_photo);

     if($request->file('client_pan_card_photo'))
     $client->client_pan_card_photo = $this->imageUploadService->handleImageUpload($request->file('client_pan_card_photo'),'clients/panCards',$client->client_pan_card_photo);

     if($request->file('client_personal_photo'))
     $client->client_personal_photo = $this->imageUploadService->handleImageUpload($request->file('client_personal_photo'),'clients/personalPhotos',$client->client_personal_photo);

     if($request->file('client_bank_cheque_photo'))
     $client->client_bank_cheque_photo = $this->imageUploadService->handleImageUpload($request->file('client_bank_cheque_photo'),'clients/bankCheques',$client->client_bank_cheque_photo);

     $client->client_first_name = $request->client_first_name;
     $client->client_middle_name = $request->client_middle_name;
     $client->client_last_name = $request->client_last_name;
     $client->client_dob = $request->client_dob;
     $client->client_phone_number = $request->client_phone_number;
     $client->client_alternate_phone_number = $request->client_alternate_phone_number;
     $client->referred_by = $request->referred_by;
     $client->commission_of_referral = $request->commission_of_referral;
     $client->client_permanent_address = $request->client_permanent_address;
     $client->client_alternate_address = $request->client_alternate_address;
     $client->client_bank_name = $request->client_bank_name;
     $client->client_bank_branch = $request->client_bank_branch;
     $client->client_bank_ifsc_code = $request->client_bank_ifsc_code;
     $client->client_bank_micr_code = $request->client_bank_micr_code;
     $client->client_bank_account_number = $request->client_bank_account_number;

     $client->save();

     Session::flash('success', 'Client updated successfully');
     return response()->json(['success'=>'Client updated successfully.']);

   }

   //to softdelete the client entry
   public function destroyClient($id)
   {

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
