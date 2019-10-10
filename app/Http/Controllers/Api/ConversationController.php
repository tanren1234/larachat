<?php

namespace App\Http\Controllers\Api;

use App\Model\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConversationCollection;
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

        $query = $query->with(['message'=> function($query){
            $query->orderBy('updated_at','desc');
        }])->whereHas('users', function ($query) use($uid) {
            // 私聊会话关联存在
            $query->where('user_id', $uid);
        })->orWhereHas('groups',function ($query) use($uid) {
            // 群组会话关联存在
            $query->whereHas('users',function ($uquery) use($uid){
                $uquery->where('user_id', $uid);
            });
        });

        $conversations = $query->paginate(5);

        return $this->success(new ConversationCollection($conversations));
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
