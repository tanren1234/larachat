<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/3/28
 * Time: 16:23
 */
namespace App\Helpers;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionReport{
    use ApiReponse;

    public $exception;

    public $request;

    public $report;

    /**
     * ExceptionReport constructor.
     * @param Request $request
     * @param Exception $exception
     */
    public function __construct(Request $request,Exception $exception)
    {
        $this->request = $request;
        $this->exception = $exception;
    }

    /**
     * @var array
     */
    public $doReport = [
        AuthenticationException::class => ['请先登录',401],
        ModelNotFoundException::class => ['改模型未找到',404],
        NotFoundHttpException::class => ['路由未定义',404],
        ValidationException::class => ['验证错误',1003]
    ];

    /**
     * @return bool
     */
    public function shouldReturn(){

       // dd($this->request->wantsJson() , $this->request->ajax());
       // if (! ($this->request->expectsJson() || $this->request->ajax())){
       //     return false;
      //  }

        foreach (array_keys($this->doReport) as $report){

            if ($this->exception instanceof $report){

                $this->report = $report;
                return true;
            }
        }

        return false;

    }

    /**
     * @param Exception $e
     * @return static
     */
    public static function make(Exception $e){

        return new static(\request(),$e);
    }

    /**
     * @return mixed
     */
    public function report(){

        $message = $this->doReport[$this->report];
        if($this->exception instanceof ValidationException){
            return $this->failed(array_values($this->exception->errors())[0][0],$message[1]);
        }
        return $this->failed($message[0],$message[1]);

    }
}