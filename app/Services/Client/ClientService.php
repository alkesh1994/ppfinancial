<?php

namespace App\Services\Client;

use App\Http\Requests\Client\StoreClientRequest;
use App\Models\Client\Client;

class ClientService
{

   //process and store data
   public function storeData(StoreClientRequest $request){

     $clientAadharCardPhotoPath = $this->handleUploadedImage($request->file('client_aadhar_card_photo'),'aadharCards');

     $clientPanCardPhotoPath = $this->handleUploadedImage($request->file('client_pan_card_photo'),'panCards');

     $clientPersonalPhotoPath = $this->handleUploadedImage($request->file('client_personal_photo'),'personalPhotos');

     $clientBankChequePhotoPath = $this->handleUploadedImage($request->file('client_bank_cheque_photo'),'bankCheques');

     $storeData = Client::create([
       'client_first_name' => $request->get('client_first_name'),
       'client_middle_name' => $request->get('client_middle_name'),
       'client_last_name' => $request->get('client_last_name'),
       'nominee_first_name' => $request->get('nominee_first_name'),
       'nominee_middle_name' => $request->get('nominee_middle_name'),
       'nominee_last_name' => $request->get('nominee_last_name'),
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

   function handleUploadedImage($image,$type){

     //handle image upload
     $imagePath = "uploads/clients/".$type."/".time().str_random(10).$image->getClientOriginalName();
     $image->move("uploads/clients/".$type, $imagePath);

     return $imagePath;

   }
}
