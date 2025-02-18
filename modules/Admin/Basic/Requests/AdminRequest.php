<?php

/**
 * Author: wtySk
 * Time: 13/11/2018  13:38
 */

namespace Modules\Admin\Basic\Requests;

use Modules\Core\Libs\Foundation\BaseRequest;

class AdminRequest extends BaseRequest
{
    function rules(): array
    {
        return match (request()->route()->getActionMethod()) {
            'store' => [
                'name' => 'required',
                'username' => 'required|unique:admin',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
            ],
            'update' => [
                'name' => 'required',
            ],
            default => [],
        };


    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => '请填写姓名',
            'username.required' => '请填写用户名',
            'username.unique' => '用户名已存在',
            'password.required' => '请填写密码',
            'password.min' => '密码不能少于6位',
            'confirm_password.required' => '请填写确认密码',
            'confirm_password.same' => '两次密码输入不一致',
        ];
    }
}
