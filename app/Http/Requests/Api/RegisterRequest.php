<?php
namespace App\Http\Requests\Api;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/5 0005
 * Time: 15:45
 */
class RegisterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'password' => 'required|string|between:6,32',
        ];

        $login_type = isset($this->register_type) ? $this->register_type : 'name';

        if( $login_type == 'phone'){

            $rules['phone']  = 'required|digits:11|regex:/^1[34578][0-9]{9}$/|unique:users,phone,' . $this->phone;

            $rules['code'] = 'required|digits:6';

        }else{

            $rules['name']  = 'required|string|unique:users,name,' . $this->name;

        }

        return $rules;
    }

    public function messages()
    {
        return [
            'phone.required'=>'手机号必须',
            'phone.digits'=>'手机号格式错误',
            'phone.regex'=>'手机号格式错误',
            'phone.unique'=>'手机号已存在',
            'password.required'=>'密码必须',
            'password.between'=>'密码长度必须在6-32之间',
            'name.required'=>'用户名必须',
            'name.unique'=>'用户名已存在',
        ];
    }
}