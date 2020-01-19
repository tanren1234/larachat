<?php
namespace App\Model;
use App\Services\MessageService;
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
    protected $fillable = ['body','conversatoin_id','user_id','type','url','cover_pic','extra'];

    protected $table = 'im_messages';

    public function getUrlAttribute($path)
    {
        // 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if ($path && ! starts_with($path, 'http')) {

            // 拼接完整的 URL
            $path = config('app.url') . $path;
        }

        return $path;
    }
    /**
     * 发送者
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function unreadCount($user_id)
    {
        return MessageNotification::where('user_id', $user_id)
            ->where('is_seen', 0)
            ->count();
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
     * @param MessageService $message_service
     * @param $user_id
     * @param string $type
     * @return mixed
     */
    public static function send(Conversation $conversation, MessageService $message_service, $user_id, $type = 'text')
    {
        $message = $conversation->messages()->create([
            'body' => $message_service->getBody(),
            'url' => $message_service->getUrl(),
            'cover_pic' => $message_service->getCoverPic(),
            'extra' => $message_service->getExtra(),
            'user_id' => $user_id,
            'type' => $type
        ]);

        return $message;
    }
}
