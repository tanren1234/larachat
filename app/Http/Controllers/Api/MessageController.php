<?php
namespace App\Http\Controllers\Api;

use App\Facades\ChatFacade as Chat;
use App\Http\Controllers\Controller;
use App\Model\Group;
use App\Model\Message;
use App\User;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: tanliang
 * Date: 2019/9/9
 * Time: 18:13
 */
class MessageController extends Controller
{
    /**
     * 列表
     *
     * @param Request $request
     */
    public function index(Request $request, Message $message)
    {
        $query = $message->query();
        $query = $query->where('user_id',$request->user()->id);
        $messages = $query->paginate(20);
        return $this->success($messages);
    }

    /**
     * 发送私信
     *
     * @param Request $request
     * @param User $user
     * @param int $conversation_id
     */
    public function store(Request $request,User $user,$conversation_id = 0)
    {

        $conversation = Chat::createConversation([$request->user()->id,$user->id],$conversation_id);

        Chat::message('Hello'.now())
              ->from($request->user()->id)
              ->to($conversation)
              ->send();
    }

    // 发送群组消息
    public function storeGroupMessage(Request $request,Group $group)
    {

        $conversation = Chat::createConversationGroup($group->id);

        Chat::message('Hello'.now())
            ->from($request->user()->id)
            ->to($conversation)
            ->send();
    }
}
