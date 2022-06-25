<?php

namespace App\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
            ],
            'mobile' => [
                'required', 'integer', 'digits:11','unique:admin_users,mobile,'.$this->user->id,
            ],
            'status' => [
                'required',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '请输入名称',
            'mobile.required' => '请输入手机号',
            'mobile.integer' => '手机号必须为数字',
            'mobile.digits' => '手机号必须为:digits位',
            'mobile.exists' => '手机号不存在或被禁止登录',
            'mobile.unique' => '手机号不能重复',
            'status.required' => '请输入状态',
        ];
    }
}
