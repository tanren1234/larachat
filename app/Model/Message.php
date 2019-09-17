<?php
namespace App\Model;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: tanliang
 * Date: 2019/9/9
 * Time: 20:44
 */
class Message extends Model
{
    protected $fillable = ['body','conversatoin_id','user_id','type'];

    protected $table = 'im_messages';

    /**
     * 发送者
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * 所属会话
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    /**
     * 发送消息
     * @param Conversation $conversation
     * @param $body
     * @param $user_id
     * @param string $type
     * @return Model
     */
    public static function send(Conversation $conversation, $body, $user_id, $type = 'text')
    {
        $message = $conversation->message()->create([
            'body' => $body,
            'user_id' => $user_id,
            'type' => $type
        ]);

        return $message;
    }
}
