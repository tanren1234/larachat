<?php

namespace App\Http\Controllers\Api;

use App\Model\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConversationsCollection;
use App\Http\Resources\Conversation as ConversationResource;

class ConversationController extends Controller
{
    /**
     *  Display a listing of the resource.
     *
     * @param Request $request
     * @param Conversation $conversation
     * @return mixed
     */
    public function index(Request $request, Conversation $conversation)
    {
        $query = $conversation->query();

        $uid = $request->user()->id;

        $query = $query->with(['lastMessage.sender','users','groups.users'])->whereHas('users', function ($query) use($uid) {
            // 私聊会话关联存在
            $query->where('user_id', $uid);
        })->orWhereHas('groups',function ($query) use($uid) {
            // 群组会话关联存在
            $query->whereHas('users',function ($uquery) use($uid){
                $uquery->where('user_id', $uid);
            });
        });

        $conversations = $query->where('private',1)->orderBy('updated_at','desc')->paginate(2);

        return $this->success(new ConversationsCollection($conversations));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $conversation = Conversation::with('messages.sender')->where('id',$id)->first();

        return $this->success(new ConversationResource($conversation));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
