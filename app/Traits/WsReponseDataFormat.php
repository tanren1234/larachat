<?php
namespace App\Traits;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/18 0018
 * Time: 22:44
 */
trait WsReponseDataFormat {

    public function success_data($data = [], $msg = 'success', $code = 0)
    {
        $data = [
            'code'=>$code,
            'data'=>$data,
            'msg'=>$msg,
        ];
        return json_encode($data);
    }

    public function fail_data($data = [], $msg = 'fail', $code = -1)
    {
        $data = [
            'code'=>$code,
            'data'=>$data,
            'msg'=>$msg,
        ];
        return json_encode($data);
    }
}
