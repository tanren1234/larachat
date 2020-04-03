<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Message extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ismine' => $request->user() ? ($this->user_id === $request->user()->id ? true : false) : false,
            'content' => $this->body,
            'conversation_id' => $this->conversation_id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'url' => $this->url,
            'cover_pic' => $this->cover_pic,
            'extra' => $this->extra,
            'created_at' => date('Y-m-d H:i:s',strtotime($this->created_at)),
            'sender' => $this->sender
        ];
    }
}
