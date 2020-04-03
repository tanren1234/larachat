<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ConversationsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->eachCollection($this->collection->toArray(), $request),
            'meta' => [
                'current_page' => $this->resource->currentPage(),
                'total' => $this->resource->total(),
            ]
        ];
    }

    /**
     * 会话类型区分
     * @param $data
     * @param $request
     * @return array
     */
    public function eachCollection($data, $request)
    {
        $items = [];

        if ($data) foreach ($data as $k => $v) {
            if ($v['type'] == 2 && $v['groups'] && isset($v['groups'][0])) {
                $info = $v['groups'][0];
                $groups = [
                    'id' => $info['id'],
                    'name' => $info['name'],
                    'creator' => $info['creator'],
                    'users' => $info['users'],
                ];
                $users = [];
            } else {
                $groups = [];
                $users = $v['users'];
                foreach ($users as $k1 => $u) {
                    if ($u['id'] === $request->user()->id) {
                        unset($users[$k1]);
                    }
                }
                $users = array_values($users)[0];
            }
            $last_message = $v['last_message'];
            $last_message['content'] = $v['last_message']['body'];
            $items[] = [
                'id' => $v['id'],
                'type' => $v['type'],
                'last_message' => $last_message,
                'groups' => $groups,
                'users' => $users,
                'num'=> 99,
                'time'=>date('i:s',strtotime($v['last_message']['updated_at']))
            ];
        }
        return $items;
    }
}
