<?php
namespace App\Http\Requests\Api;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/5 0005
 * Time: 15:45
 */
class AuthorizationRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'password' => 'required|string',
        ];

        $login_type = isset($this->login_type) ? $this->login_type : 'name';

        if( $login_type == 'phone'){

            $rules['phone']  = 'required|regex:/^1[34578][0-9]{9}$/|exists:users,phone';

        }else{

            $rules['name']  = 'required|string|exists:users,name';

        }

        return $rules;
    }

    public function messages()
    {
        return [
            'phone.required'=>'手机号必须',
            'phone.exists'=>'手机号不存在,请先注册',
            'phone.regex'=>'手机号格式错误',
            'password.required'=>'密码必须',
            'name.required'=>'用户名必须',
            'name.exists'=>'用户名不存在,请先注册',
        ];
    }
}