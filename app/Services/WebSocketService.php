<?php
namespace App\Services;
use App\Traits\WsCheckToken;
use App\Traits\WsReponseDataFormat;
use Hhxsv5\LaravelS\Swoole\WebSocketHandlerInterface;

use Illuminate\Support\Facades\Log;
use Swoole\WebSocket\Server;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/30 0030
 * Time: 15:20
 */
class WebSocketService implements WebSocketHandlerInterface
{

    use WsReponseDataFormat,WsCheckToken;

    protected $publicKey;

    protected $fdLiveCycle;

    protected $pushService;

    public function __construct()
    {
        $this->fdLiveCycle = new FdLiveCycleService();
        $this->pushService = new PushService();
    }

    public function onOpen(Server $server, Request $request)
    {
        Log::info('New WebSocket connection', request()->all());
        // TODO: Implement onOpen() method.
        // 在触发onOpen事件之前Laravel的生命周期已经完结，所以Laravel的Request是可读的，Session是可读写的
        // \Log::info('New WebSocket connection', [$request->fd, request()->all(), session()->getId(), session('xxx'), session(['yyy' => time()])]);
        // 验证token
        try{
            $user_id = $this->check(request()->get('token'));
            // 绑定userId和Fd
            $this->fdLiveCycle->setFd($user_id, $request->fd);

            // 记录在线状态

            // 广播至好友 使用异步任务
        }catch (\Exception $exception){
            $this->pushService->pushFd($server, $request->fd, $exception->getMessage());
            $server->close($request->fd);
        }
    }

    public function onMessage(Server $server, Frame $frame)
    {
        // TODO: Implement onMessage() method.
        Log::info('Received message', [$frame->fd, $frame->data, $frame->opcode, $frame->finish]);
        $server->push($frame->fd, date('Y-m-d H:i:s'));
    }

    public function onClose(Server $server, $fd, $reactorId)
    {
        // TODO: Implement onClose() method.
    }
}
