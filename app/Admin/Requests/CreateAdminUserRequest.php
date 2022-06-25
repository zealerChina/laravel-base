<?php

namespace App\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminUserRequest extends FormRequest
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
                'required', 'integer', 'digits:11','unique:admin_users,mobile',
            ],
            'password' => [
                'required', 'min:6',
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
            'password.required' => '请输入验证码',
            'password.min' => '密码必须大于:min位',
            'status.required' => '请输入状态',
        ];
    }
}
