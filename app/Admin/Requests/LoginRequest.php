<?php

namespace App\Admin\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile' => [
                'required', 'integer', 'digits:11',
                // 检查用户状态是否正常，以及是否超过当日最大失败次数
                Rule::exists('admin_users')->where(function ($query) {
                    $query->where('status', 'normal');
                }),
            ],
            'password' => [
                'required', 'min:6',
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
            'mobile.required' => '请输入手机号',
            'mobile.integer' => '手机号必须为数字',
            'mobile.digits' => '手机号必须为:digits位',
            'mobile.exists' => '手机号不存在或被禁止登录',
            'password.required' => '请输入验证码',
            'password.min' => '密码必须大于:min位',
        ];
    }
}
