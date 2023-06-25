<?php

namespace App\Http\Requests\Api\Role;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'name.required' => 'Chưa nhập tên quyền',
            'permision.required' => 'Chưa set quyền',
        ];
    }

    public function rules()
    {
        return [
            'name' => 'string|required',
            'permision' => 'required|array'
        ];
    }
}
