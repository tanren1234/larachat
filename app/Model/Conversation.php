<?php
namespace App\Model;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: tanliang
 * Date: 2019/9/9
 * Time: 19:43
 */
class Conversation extends Model
{
    protected $fillable = ['data'];
    protected $table = 'im_conversations';
    protected $casts = [
        'data' => 'array'
    ];
    protected $private = true;

    public function users()
    {
        return $this->belongsToMany(User::class,'im_conversation_user','conversation_id','user_id')->withTimestamps();
    }

    public function message()
    {
        return $this->hasMany(Message::class,'conversation_id');
    }
    /**
     * 开启一个会话
     * @param $participants
     * @param array $data
     * @return mixed
     */
    public function start($participants, $data = [])
    {
        $conversation = $this->create(['data' => $data]);

        if ($participants) {
            $conversation->addParticipants($participants);
        }

        return $conversation;
    }

    /**
     * 添加用户到会话中
     * @param $userIds
     * @return $this
     */
    public function addParticipants($userIds)
    {
        if (is_array($userIds)) {
            foreach ($userIds as $id){
                $this->users()->attach($id);
            }
        } else {
            $this->users()->attach($userIds);
        }

        if ($this->fresh()->users()->count()>2) {
            $this->private = false;
            $this->save();
        }

        return $this;
    }
}
