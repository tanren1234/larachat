<?php
namespace App\Sockets;
use Hhxsv5\LaravelS\Swoole\Socket\TcpSocket;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/30 0030
 * Time: 20:15
 */
class TestTcpSocket extends TcpSocket
{
    public function onConnect(\swoole_server $server, $fd, $reactorId)
    {
        \Log::info('New TCP connection', [$fd]);
        $server->send($fd, 'Welcome to LaravelS.');
    }
    public function onReceive(\swoole_server $server, $fd, $reactorId, $data)
    {
        \Log::info('Received data', [$fd, $data]);
        $server->send($fd, 'LaravelS: ' . $data);
        if ($data === "quit\r\n") {
            $server->send($fd, 'LaravelS: bye' . PHP_EOL);
            $server->close($fd);
        }
    }
    public function onClose(\swoole_server $server, $fd, $reactorId)
    {
        \Log::info('Close TCP connection', [$fd]);
        $server->send($fd, 'Goodbye');
    }

}