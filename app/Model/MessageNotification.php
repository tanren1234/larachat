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

    public static function make(Message $message,Conversation $coversation)
    {
        $notification = [];

        if ($coversation->users) {
            foreach ($coversation->users as $user) {
                $is_sender = ($message->user_id == $user->id) ? 1 : 0;

                $notification[]=[
                    'user_id' => $user->id,
                    'message_id' => $message->id,
                    'conversation_id' => $coversation->id,
                    'is_seen' => $is_sender,
                    'is_seeder' => $is_sender,
                    'created_at' => $message->created_at
                ];
            }

            self::insert($notification);
        }

    }
}
