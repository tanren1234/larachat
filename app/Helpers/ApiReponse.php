<?php
namespace App\Helpers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/5 0005
 * Time: 14:47
 */
trait ApiReponse{
    /**
     * @var int
     */
    protected $statusCode = FoundationResponse::HTTP_OK;

    /**
     * @return int
     */
    public function getStatusCode(){
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {

        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param $data
     * @param array $header
     * @return mixed
     */
    public function respond($data, $header = [])
    {
        return response()->json($data);
    }

    /**
     * @param $msg
     * @param array $data
     * @param null $code
     * @return mixed
     */
    public function status($msg, array $data, $code = null){

        if ($code){
            $this->setStatusCode($code);
        }

        $status = [
            'msg' => $msg,
            'code' => $this->statusCode
        ];

        $data = array_merge($status,$data);

        return $this->respond($data);

    }

    /**
     * @param $message
     * @param int $code
     * @param string $status
     * @return mixed
     */
    public function failed($code = FoundationResponse::HTTP_BAD_REQUEST , ...$message){
       // return $this->setStatusCode($code)->message($message,$status);

        return $this->setStatusCode($code)->status(!empty($message) ? $message[0] : $this->errorMsg($code),['data'=>[]]);
    }
    /**
     * @param $data
     * @param string $msg
     * @return mixed
     */
    public function success($data, $msg = "success"){

        return $this->status($msg,compact('data'));
    }
    /**
     * @param $message
     * @param string $status
     * @return mixed
     */
    public function message($message, $status = "success"){

        //return $this->status($status,[
        //    'message' => $message
       // ]);
        return $this->status($message,[]);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function internalError($message = "Internal Error!"){

        return $this->failed($message,FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function created($message = "created")
    {
        return $this->setStatusCode(FoundationResponse::HTTP_CREATED)
            ->message($message);

    }

    /**
     * @param string $message
     * @return mixed
     */
    public function notFond($message = 'Not Fond!')
    {
        return $this->failed($message,Foundationresponse::HTTP_NOT_FOUND);
    }

    public function errorMsg($code)
    {
        return Config::get('api_code.'.$code,'') ?: 'error';
    }
}
