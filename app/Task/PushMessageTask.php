<?php
namespace App\Task;
use App\Http\Resources\Message as messageResources;
use App\User;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Illuminate\Support\Facades\Log;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/17 0017
 * Time: 22:00
 */
class PushMessageTask extends Task
{
    private $data;

    private $result;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * {
        sender: {
        avatar: require('@/assets/avater.png')
        },
        type: 'text',
        conversation_id: 1,
        user_id: 2,
        content: '大声道sad嘻嘻和他的朋友们嘻嘻和他的朋友们嘻嘻和他的朋友们嘻嘻和他的朋友们嘻嘻和他的朋友们嘻嘻和他的朋友们嘻嘻和他的朋友们',
        ismine: true
        }
     *
      {
        id: 2,
        type: 1,
        last_message: {
        id: 2,
        body: 'Hello123',
        type: 'text',
        sender: {
        name: 'qweasda'
        }
        },
        groups: [],
        users: {
        id: 2,
        name: 'fafawlp',
        phone: '13048901611',
        avatar: require('@/assets/avater.png')

        },
        num: 99,
        time: '12:29'
        }
     */
    public function handle()
    {
        // TODO: Implement handle() method.
        // 推送消息的逻辑处理
        $message = $this->data['message'];
        if ($message->conversation->type == 1) {
            $users = User::find($message->user_id);
        }else{
            $groups = [
                'id'=>$message->conversation->groups->id,
                'name'=>$message->conversation->groups->name,
                'creator'=>$message->conversation->groups->creator,
                'users' => $message->conversation->groups->users
            ];
        }
        $item = [
            'id' => $message->conversation->id,
            'type' => $message->conversation->type,
            'last_message' => new messageResources($message),
            'groups' => $groups??[],
            'users' => $users??[],
            'num'=> $message->unreadCount($message->user_id), // 未读数
            'time'=>date('H:i',strtotime($message->created_at))
        ];
        app('swoole')->push($this->data['fd'],json_encode($item));

        $this->result = 'the result of ' . json_encode($item);
    }
    // 可选的，完成事件，任务处理完后的逻辑，运行在Worker进程中，可以投递任务
    public function finish()
    {
        Log::info(__CLASS__ . ':finish start', [$this->result]);
       // Task::deliver(new TestTask2('task2')); // 投递其他任务
    }
}
