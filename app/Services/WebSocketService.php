<?php
namespace App\Services;
use App\Helpers\WsReponseDataFormat;
use Hhxsv5\LaravelS\Swoole\WebSocketHandlerInterface;

use Illuminate\Container\Container;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\CryptTrait;
use League\OAuth2\Server\ResourceServer;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/30 0030
 * Time: 15:20
 */
class WebSocketService implements WebSocketHandlerInterface{
    use CryptTrait,WsReponseDataFormat;

    protected $publicKey;

    protected $fdLiveCycle;

    public function __construct()
    {
        $this->fdLiveCycle = new FdLiveCycle();
    }

    public function onOpen(\swoole_websocket_server $server, \swoole_http_request $request)
    {
        // TODO: Implement onOpen() method.
        // 在触发onOpen事件之前Laravel的生命周期已经完结，所以Laravel的Request是可读的，Session是可读写的
       // \Log::info('New WebSocket connection', [$request->fd, request()->all(), session()->getId(), session('xxx'), session(['yyy' => time()])]);
        // 验证token
        $check = $this->check(request()->get('token'));

        if ($check['code']==0) {
            // 绑定userId和Fd
            $this->fdLiveCycle->setFd($check['data']['user_id'], $request->fd);

            $server->push($request->fd, $this->success_data(['user_id'=>$check['data']['user_id']],'Welcome to LaravelS'));

            // 记录在线状态

             // 广播至好友 使用异步任务
        } else {
            $server->push($request->fd, $check['msg']);
        }

    }

    public function onMessage(\swoole_websocket_server $server, \swoole_websocket_frame $frame)
    {
        // TODO: Implement onMessage() method.
        \Log::info('Received message', [$frame->fd, $frame->data, $frame->opcode, $frame->finish]);
        $server->push($frame->fd, date('Y-m-d H:i:s'));
    }

    public function onClose(\swoole_websocket_server $server, $fd, $reactorId)
    {
        // TODO: Implement onClose() method.
    }

    /**
     * 验证token
     * @param $jwt
     * @return array
     */
    public function check($jwt)
    {
        $container  = Container::getInstance();
        $resource = $container->make(ResourceServer::class);
        $key = new CryptKey($resource->publicKey->getKeyPath(),null,false);

        // Attempt to parse and validate the JWT
        $token = (new Parser())->parse($jwt);
        try {
            if ($token->verify(new Sha256(), $key->getKeyPath()) === false) {
              $return =['code'=>-1,'msg'=>'Access token could not be verified'];
            }else {
                $return =['code'=>0,'msg'=>'success','data'=>['user_id'=>$token->getClaim('sub')]];
            }
        } catch (BadMethodCallException $exception) {
            $return =['code'=>-1,'msg'=>'Access token is not signed'];
        }

        return $return;
    }

}
