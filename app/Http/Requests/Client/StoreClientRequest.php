<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'client_first_name' => 'required|max:50',
          'client_middle_name' => 'required|max:50',
          'client_last_name' => 'required|max:50',
          'client_dob' => 'required',
          'client_phone_number' => 'required|numeric',
          'client_alternate_phone_number' => 'nullable|numeric',
          'client_permanent_address' => 'required',
          'client_aadhar_card_photo' => 'required|image',
          'client_pan_card_photo' => 'required|image',
          'client_personal_photo' => 'required|image',
          'client_bank_name' => 'required',
          'client_bank_account_number' => 'required|numeric',
          'client_bank_ifsc_code' => 'required',
          'client_bank_micr_code' => 'required',
          'client_bank_branch' => 'required',
          'client_bank_cheque_photo' => 'required|image',
        ];
    }
}
