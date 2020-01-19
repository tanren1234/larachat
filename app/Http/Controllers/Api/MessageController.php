<?php
namespace App\Http\Controllers\Api;

use App\Facades\ChatFacade as Chat;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageCollection;
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
     * @param Request $request
     * @param $conversation_id
     * @return mixed
     */
    public function index(Request $request, $conversation_id)
    {
        $messages = Message::with('sender')->where('conversation_id',$conversation_id)->orderBy('id','desc')->paginate(10);

        return $this->success(new MessageCollection($messages));
    }

    /**
     * 发送私信
     * @param Request $request
     * @param User $user
     * @param int $conversation_id
     * @return mixed
     */
    public function store(Request $request,User $user,$conversation_id = 0)
    {
        $conversation = Chat::createConversation([$request->user()->id,$user->id],$conversation_id);

        $messages = Chat::message($request->post('content','Hello'.now()))
              ->type($request->post('type','text'))
              ->from($request->user()->id)
              ->to($conversation)
              ->send();
        return $this->success(new \App\Http\Resources\Message($messages));
    }

    // 发送群组消息
    public function storeGroupMessage(Request $request, $group_id)
    {
        $conversation = Chat::createConversationGroup($group_id);

        $messages = Chat::message('Hello'.now())
            ->from($request->user()->id)
            ->to($conversation)
            ->send();
        return $this->success(new \App\Http\Resources\Message($messages));
    }
}
