<?php
namespace App\Task;
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

    public function handle()
    {
        // TODO: Implement handle() method.
        // 推送消息的逻辑处理
        app('swoole')->push($this->data['fd'],json_encode($this->data['info']));

        $this->result = 'the result of ' . $this->data;
    }
    // 可选的，完成事件，任务处理完后的逻辑，运行在Worker进程中，可以投递任务
    public function finish()
    {
        Log::info(__CLASS__ . ':finish start', [$this->result]);
       // Task::deliver(new TestTask2('task2')); // 投递其他任务
    }
}
