<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->when($request->is('/posts'), $this->description),
            'tags'        => TagResource::collection($this->whenLoaded('tags')),
            'author'      => new UserResource($this->whenLoaded('author')),
            'likes_count' => $this->whenCounted('likes'),
            'created_at'  => $this->created_at,
        ];
    }
}
