<?php
namespace App\Services;
use App\Model\Conversation;

/**
 * Created by PhpStorm.
 * User: tanliang
 * Date: 2019/9/9
 * Time: 20:03
 */
class ConversationService
{
    protected $isPrivate = null;

    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * 创建会话
     * @param $participants
     * @param array $data
     * @return mixed
     */
    public function start($participants, $data = [])
    {
        return $this->conversation->start($participants, $data);
    }

}
