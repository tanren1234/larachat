<?php
namespace App\Services;

use App\Traits\WsReponseDataFormat;
use Swoole\WebSocket\Server;
/**
 * Created by PhpStorm.
 * User: tanliang
 * Date: 2019/9/4
 * Time: 20:57
 */
class PushService
{
    use WsReponseDataFormat;
    public function __construct()
    {
    }

    /**
     * @param $service
     * @param $fd
     * @param $data
     */
    public function pushFd(Server $service, $fd, $data)
    {
        Log::info('push WebSocket connection', $data);
        $service->push($fd, $data);
    }
}
