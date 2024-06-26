<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdoptionRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name_adopter' => 'required',
            'phone_adopter' => 'required',
            'address_adopter' => 'required',
            'user_id'=>'required',
            'email' => 'required',
            'pet_id' => 'required',
            'description' => 'required|string|max:1000',
            'reject' => 'string|max:1000',
        ];
    }
}
