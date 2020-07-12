<?php

namespace App\Services\Client;

use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client\Client;
use App\Services\Helpers\SlugService;
use App\Services\Helpers\ImageUploadService;
use File;

class ClientService
{

   //process and store data
   public function storeData(StoreClientRequest $request){

     $sluggableField = $request->get('client_first_name').' '.$request->get('client_middle_name').' '.$request->get('client_last_name').' '.str_random(10);
     $slugService = new SlugService();
     $slug = $slugService->createSlug('Client\\Client',$sluggableField);

     $imageUploadService = new ImageUploadService();

     $clientAadharCardPhotoPath = $imageUploadService->handleImageUpload($request->file('client_aadhar_card_photo'),'clients/aadharCards');

     $clientPanCardPhotoPath = $imageUploadService->handleImageUpload($request->file('client_pan_card_photo'),'clients/panCards');

     $clientPersonalPhotoPath = $imageUploadService->handleImageUpload($request->file('client_personal_photo'),'clients/personalPhotos');

     $clientBankChequePhotoPath = $imageUploadService->handleImageUpload($request->file('client_bank_cheque_photo'),'clients/bankCheques');

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

     return $storeData;

   }

   //process and update data
   public function updateData(UpdateClientRequest $request,$id){

     $client = Client::findOrFail($id);

     if(($client->client_first_name != $request->client_first_name) || ($client->client_middle_name != $request->client_middle_name) || ($client->client_last_name != $request->client_last_name)){
       $sluggableField = $request->get('client_first_name').' '.$request->get('client_middle_name').' '.$request->get('client_last_name').' '.str_random(10);
       $slugService = new SlugService();
       $client->slug = $slugService->createSlug('Client\\Client',$sluggableField);
     }else{
       $slug = $client->slug;
     }

     $imageUploadService = new ImageUploadService();

     if($request->file('client_aadhar_card_photo'))
     $client->client_aadhar_card_photo = $imageUploadService->handleImageUpload($request->file('client_aadhar_card_photo'),'clients/aadharCards',$client->client_aadhar_card_photo);

     if($request->file('client_pan_card_photo'))
     $client->client_pan_card_photo = $imageUploadService->handleImageUpload($request->file('client_pan_card_photo'),'clients/panCards',$client->client_pan_card_photo);

     if($request->file('client_personal_photo'))
     $client->client_personal_photo = $imageUploadService->handleImageUpload($request->file('client_personal_photo'),'clients/personalPhotos',$client->client_personal_photo);

     if($request->file('client_bank_cheque_photo'))
     $client->client_bank_cheque_photo = $this->handleImageUpload($request->file('client_bank_cheque_photo'),'clients/bankCheques',$client->client_bank_cheque_photo);

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

     return $client;

   }
}
