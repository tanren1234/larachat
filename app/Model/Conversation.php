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
    public function groups()
    {
        return $this->belongsToMany(Group::class,'im_conversation_groups','conversation_id','group_id')->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class,'conversation_id')->groupBy('id');
    }
    public function lastMessage()
    {
        return $this->hasOne(Message::class,'conversation_id')->orderBy('id','desc');
    }
    /**
     * 开启一个会话
     * @param $participants
     * @param array $data
     * @return mixed
     */
    public function start($participants, $conversation_id = 0, $data = [])
    {
        if ($conversation_id) {
            return Conversation::with('users')->find($conversation_id);
        }

        $eq = array_intersect($this->getUserConversations($participants[0]),$this->getUserConversations($participants[1]));

        // 是否在一个会话里
        if ($eq) {
            return Conversation::with('users')->find($eq[0]);
        }
        $conversation = $this->create(['data' => $data]);

        if ($participants) {
            $this->addParticipants($conversation, $participants);
        }

        return Conversation::with('users')->find($conversation->id);
    }

    /**
     * 添加用户到会话中
     * @param $conversation
     * @param $userIds
     * @return $this
     */
    public function addParticipants($conversation, $userIds)
    {
        if (is_array($userIds)) {
            foreach ($userIds as $id){
                $conversation->users()->attach($id);
            }
        } else {
            $conversation->users()->attach($userIds);
        }

        if ($conversation->fresh()->users()->count()>2) {
            $conversation->private = false;
            $conversation->save();
        }

        return $conversation;
    }

    /**
     * 开启一个群组会话
     * @param $group_id
     * @param array $data
     * @return mixed
     */
    public function startGroup($group_id, $data = [])
    {
        $cg = ConversationGroup::where('group_id', $group_id)->first();

        if ($cg) return Conversation::with('groups.users')->where(['id'=>$cg->conversation_id,'type'=>2])->first();

        $conversation = $this->create(['data' => $data, 'private'=> false, 'type' => 2]);

        $this->addParticipantsGroups($conversation, $group_id);

        return Conversation::with('groups.users')->find($conversation->id);
    }

    /**
     * 添加群组到会话中
     * @param $conversation
     * @param $group_id
     * @return mixed
     */
    public function addParticipantsGroups($conversation, $group_id)
    {
        $conversation->groups()->attach($group_id);

        return $conversation;
    }

    /**
     * 获取用户的会话集合
     * @param $user_id
     * @return array
     */
    public function getUserConversations($user_id)
    {
        $conversation_users = ConversationUser::where('user_id', $user_id)->get()->toArray();

        return $conversation_users ? array_column($conversation_users,'conversation_id') : [];
    }
}
