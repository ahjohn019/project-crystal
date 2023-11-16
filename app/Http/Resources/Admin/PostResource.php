<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use App\Http\Services\PostService;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'likes' => $this->likes,
            'status' => $this->status,
            'popularity' => PostService::calculatePopularity($this->likes, 'likes')['popularity'],
            'popularity_percentage' => PostService::calculatePopularity($this->likes, 'likes')['popularity_percentage'],
            'popularity_grade' => PostService::fetchPopularityGrade($this->likes),
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'created_at' => $this->created_at
        ];
    }
}
