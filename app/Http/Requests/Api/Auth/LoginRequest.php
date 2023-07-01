<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */

     public function messages()
     {
         return [
             'phone.required' => 'Vui lòng nhập số điện thoại',
             'password.required' => 'Vui lòng nhập mật khẩu',
             'password.min' => 'Mật khẩu phải nhiều hơn 8 ký tự',
             'password.max' => 'Mật khẩu phải ít hơn 50 ký tự',
         ];
     }
 
    public function rules()
    {
         return [
            'phone' => 'string|required',
            'password' => 'string|required|min:8|max:50',
         ];
    }
}
