<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePetsRequest extends FormRequest
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
            'name'=>'required',
            'gender'=> 'required|in:male,female',
            'status_adopt'=>'required|in:ready,adopted',
            'certificate'=> 'required',
            'color'=>'required|string',
            'categories_id'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_birth'=>'required|date_format:Y-m-d',
            'weight'=>'required|numeric|min:0',
            'description' => 'required|string|max:500'
        ];
    }
}
