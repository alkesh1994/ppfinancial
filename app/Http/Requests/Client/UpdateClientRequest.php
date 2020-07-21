<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
          'client_first_name' => 'required|min:3|max:12',
          'client_middle_name' => 'required|min:3|max:12',
          'client_last_name' => 'required|min:3|max:12',
          'client_dob' => 'required|date',
          'client_phone_number' => 'required|numeric|digits:10',
          'client_alternate_phone_number' => 'nullable|numeric|digits:10',
          'client_permanent_address' => 'required',
          'client_aadhar_card_photo' => 'image',
          'client_pan_card_photo' => 'image',
          'client_personal_photo' => 'image',
          'referred_by' => 'nullable|min:3|max:20',
          'client_bank_name' => 'required|min:3',
          'client_bank_account_number' => 'required|numeric',
          'client_bank_ifsc_code' => 'required|size:11',
          'client_bank_micr_code' => 'required|numeric|digits:9',
          'client_bank_branch' => 'required|min:3',
          'client_bank_cheque_photo' => 'image',
        ];
    }
}
