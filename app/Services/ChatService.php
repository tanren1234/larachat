<?php
namespace App\Services;
/**
 * Created by PhpStorm.
 * User: tanliang
 * Date: 2019/9/9
 * Time: 19:56
 */
class ChatService
{
    public function __construct(MessageService $messageService, ConversationService $conversationService)
    {
        $this->conversationService = $conversationService;
        $this->messageService = $messageService;
    }

    /**
     * 创建一个会话
     * @param array $participants
     * @param array $data
     * @return mixed
     */
    public function createConversation(array $participants, array $data = [])
    {
        return $this->conversationService->start($participants, $data);
    }

    /**
     * 设置消息
     * @param $message
     * @return MessageService
     */
    public function message($message)
    {
        return $this->messageService->setMessage($message);
    }
}
