<?php

namespace App\Http\Resources\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $author
 * @property mixed $content
 * @property mixed $post
 * @property mixed $submitted_at
 */
class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'author' => $this->author->name,
            'content' => $this->content,
            'post' => $this->post->title,
            'submitted_at' => $this->submitted_at,
        ];
    }
}
