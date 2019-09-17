<?php
namespace App\Services;
use App\Model\Message;
use App\Model\MessageNotification;
use App\Task\PushMessageTask;
use App\Traits\SetsParticipants;
use Hhxsv5\LaravelS\Swoole\Task\Task;

/**
 * Created by PhpStorm.
 * User: tanliang
 * Date: 2019/9/4
 * Time: 20:44
 */
class MessageService
{
    use SetsParticipants;

    protected $body;
    protected $type = 'text';
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * 设置message
     * @param $message
     * @return $this
     */
    public function setMessage($message)
    {
        if (is_object($message)) {
            $this->message = $message;
        }else{
            $this->body = $message;
        }
        return $this;
    }

    public function send()
    {
        if (!$this->from) {
            throw new \Exception('Message sender has not been set');
        }

        if (!$this->body) {
            throw new \Exception('Message body has not been set');
        }
        // 会话对象
        if (!$this->to) {
            throw new \Exception('Message receiver has not been set');
        }

        $message = Message::send($this->to, $this->body, $this->from, $this->type);

        // 消息通知记录
        MessageNotification::make($message, $this->to);

        // push服务推送消息
        foreach ($this->to->users as $user) {

            // 过滤会话中消息发送者的推送
            if ($message->user_id == $user->id) continue;

            // 判断会话中发送的用户是否在线
            $fd = FdLiveCycleService::getUid($user->id);

            if (!empty($fd) && !empty($fd['value'])) {
                $data = [
                    'fd' => $fd['value'],
                    'info' => [
                        'type' => $this->type,
                        'body' => $this->body
                    ]
                ];

                $task = new PushMessageTask($data);

                // 投递异步任务推送消息
                $ret = Task::deliver($task);

                if ($ret) {
                    // 更新通知记录表发送状态状态
                }
            }

        }
    }
}
