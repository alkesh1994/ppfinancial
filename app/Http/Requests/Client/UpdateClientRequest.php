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
          'client_phone_number' => 'required|numeric|max:10',
          'client_alternate_phone_number' => 'nullable|numeric|max:10',
          'client_permanent_address' => 'required',
          'client_aadhar_card_photo' => 'image',
          'client_pan_card_photo' => 'image',
          'client_personal_photo' => 'image',
          'referred_by' => 'nullable|min:3|max:20';
          'client_bank_name' => 'required',
          'client_bank_account_number' => 'required|numeric|max:11',
          'client_bank_ifsc_code' => 'required|max:11',
          'client_bank_micr_code' => 'required|max:9',
          'client_bank_branch' => 'required',
          'client_bank_cheque_photo' => 'image',
        ];
    }
}
