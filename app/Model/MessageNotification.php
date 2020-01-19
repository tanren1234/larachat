<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Created by PhpStorm.
 * User: tanliang
 * Date: 2019/9/16
 * Time: 14:55
 */
class MessageNotification extends Model
{
    use SoftDeletes;
    protected $table = 'im_message_notification';

    protected $fillable = ['user_id', 'message_id', 'conversation_id'];

    protected $dates = ['deleted_at'];

    /**
     * * 生成消息通知
     * @param Message $message
     * @param Conversation $conversation
     */
    public static function make(Message $message, Conversation $conversation)
    {
        $notification= [];

        $users = $conversation->type == 1 ? $conversation->users : $conversation->groups[0]->users;

        if ($users) {

            foreach ($users as $user) {
                $is_sender = ($message->user_id == $user->id) ? 1 : 0;

                $notification[]=[
                    'user_id' => $user->id,
                    'message_id' => $message->id,
                    'conversation_id' => $conversation->id,
                    'is_seen' => $is_sender,
                    'is_sender' => $is_sender,
                    'created_at' => $message->created_at
                ];
            }

            self::insert($notification);
        }
    }

    /**
     * 修改消息通知发送状态
     * @param $user_id
     * @param $message_id
     * @param $conversation_id
     */
    public static function alertIsSendStatus($user_id, $message_id, $conversation_id)
    {
       $notification = MessageNotification::where([
           'user_id' => $user_id,
           'message_id' => $message_id,
           'conversation_id' => $conversation_id,
       ])->first();
       if ($notification) {
           $notification->is_send = 1;
           $notification->save();
       }
    }
}
