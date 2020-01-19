<?php
namespace App\Services;

use App\Model\Conversation;
use App\Model\Message;
use App\Model\MessageNotification;
use App\Task\PushMessageTask;
use App\Traits\WsReponseDataFormat;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Illuminate\Support\Facades\Log;
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

    /**
     * @param Message $message
     * @param Conversation $conversation
     */
    public static function pushMessage(Message $message, Conversation $conversation)
    {
        $users = $conversation->type == 1 ? $conversation->users : $conversation->groups->users;
        // push服务推送消息
        foreach ($users as $user) {

            // 过滤会话中消息发送者的推送
            if ($message->user_id == $user->id) continue;

            // 判断会话中发送的用户是否在线
            $fd = FdLiveCycleService::getFdToUid($user->id);

            if (!empty($fd)) {
                $data = [
                    'fd' =>$fd,
                    'message' => $message
                ];

                $task = new PushMessageTask($data);
                // 投递异步任务推送消息
                $ret = Task::deliver($task);

                if ($ret) {
                    // 更新通知记录表发送状态状态
                    MessageNotification::alertIsSendStatus($user->id, $message->id, $conversation->id);
                }
            }
        }
    }
}
