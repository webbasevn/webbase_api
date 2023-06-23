<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập họ tên bạn',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.unique' => 'Số điện thoại đã tồn tại, vui lòng chọn số khác',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải nhiều hơn 8 ký tự',
            'password.max' => 'Mật khẩu phải ít hơn 50 ký tự',
        ];
    }

    public function rules()
    {
        return [
            'name' => 'string|required',
            'phone' => 'string|required|unique:users',
            'password' => 'string|required|min:8|max:50'
        ];
    }
}
