<?php

namespace App\Http\Requests;

use Auth;
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
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'f_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            's_name' => ['nullable', 'string', 'max:255'],
            'commercial_name' => ['nullable', 'string', 'max:255'],
            'user_category_id' => ['string', 'required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email2' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'licence_number' => ['nullable', 'string', 'required_if:user_category_id,5'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'country' => ['required', 'string', 'max:3'],
            'city' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'tel1' => ['nullable', 'string', 'max:255'],
            'tel2' => ['nullable', 'string', 'max:255'],
            'mob1' => ['required', 'string', 'max:255'],
            'mob2' => ['nullable', 'string', 'max:255'],
            'tel2' => ['nullable', 'string', 'max:255'],
            'fax1' => ['nullable', 'string', 'max:255'],
            'fax2' => ['nullable', 'string', 'max:255'],
            'logo_image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,bmp,svg', 'max:5000'],
        ];
    }
}
