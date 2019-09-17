<?php
namespace App\Http\Controllers\Api;

use App\Facades\ChatFacade as Chat;
use App\Http\Controllers\Controller;
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
    // 发送消息
    public function store(Request $request,User $user)
    {

        $conversation = Chat::createConversation([$request->user()->id,$user->id]);

        Chat::message('Hello')
              ->from($request->user()->id)
              ->to($conversation)
              ->send();
    }
}
