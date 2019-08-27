<?php
namespace App\Http\Proxy;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/5 0005
 * Time: 14:47
 */
class TokenProxy{

    public function proxy($grantType , array $data= []){

        $data = array_merge($data , [
            'client_id'=>env('PASSPORT_ID'),
            'client_secret'=>env('PASSPORT_SECRET'),
            'grant_type'=>$grantType,
            'scope'=>''
        ]);

        try {

            $http = new Client();

            $respose = $http->post(config('api.porxy_url').'/oauth/token',[
                'form_params'=>$data
            ]);

        } catch (RequestException $e) {
            if ($e->hasResponse()) {

                //$response = new Psr7\Response();
                //echo Psr7\str($e->getResponse());
                //dd(json_decode((string)Psr7\str($e->getResponse(),true)));
                return [
                    'code'=>1001
                ];
            }
        }

        $token = json_decode((string)$respose->getBody(),true);

        if(isset($token['access_token']) && $token['access_token']){

            return [
                'code'=>200,
                'data'=>[
                    'token' => $token['access_token'],
                    'refresh_token' => $token['refresh_token'],
                    'expires_in' => $token['expires_in'] // 单位秒
                ]
            ];
        }else{
            return [
                'code'=>1002
            ];
        }

    }
}
