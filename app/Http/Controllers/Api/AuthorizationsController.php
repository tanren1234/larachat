<?php
namespace App\Http\Controllers\Api;

use App\Helpers\ApiReponse;
use App\Http\Controllers\Controller;
use App\Http\Proxy\TokenProxy;
use App\Http\Requests\Api\AuthorizationRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Traits\WsCheckToken;
use App\User;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/5 0005
 * Time: 14:47
 */
class AuthorizationsController extends Controller {

    use ApiReponse,WsCheckToken;
    /**
     * 登录
     * @param AuthorizationRequest $request
     * @return mixed
     */
    public function login(AuthorizationRequest $request)
    {
        $token = new TokenProxy();

        $login_type = isset($request->login_type) ? $request->login_type : 'name';

        if($login_type == 'phone'){
            $data = [
                'username'=>$request->phone,
                'password'=>$request->password
            ];
        }else{
            $data = [
                'username'=>$request->name,
                'password'=>$request->password
            ];
        }

        $res =  $token->proxy('password',$data);

        if($res['code']==200) return $this->success($res['data']);

        return $this->failed($res['code']);
    }

    /**
     * 注册
     * @param RegisterRequest $request
     * @return mixed
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->only('phone','code','password','name');

        $register_type = $request->register_type ?? 'name';

        if($register_type == 'phone'){
            if('123456'==$data['code']){
                $create_info = [
                    'phone' => $data['phone'],
                    'password' => bcrypt($data['password']),
                    'name' => generateNumber()
                ];

            }else{
                return $this->failed(1004);
            }
        }else{
            $create_info = [
                'password'=>bcrypt($data['password']),
                'name'=>trim($data['name'])
            ];

        }

        $return = User::create($create_info);

        if($return){
            $token = $return->createToken($return->id)->accessToken;

            return $this->success([
                            'access_token'=>$token,
                            'token_type' => 'Bearer'
                        ],'注册成功');
        }else{
            return $this->failed(1005);
        }

    }

    public function checkToken()
    {
        try{
            $this->check(request()->post('token'));
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }

    }
}
