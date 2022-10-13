<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        'name'=>'required',
        'email'=>'required|email|unique:users',
        'password'=>'required',
        'address'=>'required',
        'phone'=>'required',
        'hobby'=>'required'

            //
        ];
    }
    // public function messages()
    // {
    // return [
    //     'name.required' => 'A title is required',
    //     'email.required' => 'A message is required',
    //     'password.required' => 'A message is required',
    //     'address.required' => 'A message is required',
    //     'phone.required' => 'A message is required',
    // ];
}
