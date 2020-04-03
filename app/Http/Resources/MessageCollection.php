<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MessageCollection extends ResourceCollection
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
            'data' =>$this->collection->sortBy('id')->all(),
            'meta' => [
                'current_page' => $this->resource->currentPage(),
                'total' => $this->resource->total(),
            ]
        ];
    }
}
