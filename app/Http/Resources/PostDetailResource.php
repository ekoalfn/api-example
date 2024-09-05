<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'news_content' => $this->news_content,
            'created_at' => date_format($this->created_at, "d/m/Y H:i:s"),
            'author' => $this->whenLoaded('Writer'),
            'comment' => $this->whenLoaded('Comment', function(){
                return collect($this->comment)->each(function($comment){
                    $comment->commentator;
                });
            }),
            'total_comment' => $this->whenLoaded('comment', function(){
                return $this->comment->count();
            })
        ];
    }
}
