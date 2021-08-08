<?php

namespace App\Http\Resources;

use App\Models\Category;
use Carbon\Carbon;
use Conner\Tagging\Taggable;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    use Taggable;
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
            'title' => $this->title,
            'description' => $this->description,
            'body' => $this->body,
            'slug' => $this->slug,
            'is_live' => $this->is_live,
            'close_to_comment' => $this->close_to_comment,
            'likes_count' => $this->likes()->count(),
            'created_at_dates' => [
                'created_at_human' => $this->created_at->diffForHumans(),
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('M d Y'),
            ],
            'updated_at_dates' => [
                'updated_at_human' => $this->updated_at->diffForHumans(),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('M d Y')
            ],
            'category' => new CategoryResource($this->category), //Category relationship defined in Article model
            'user' => new UserResource($this->user),
            'comments_count' => $this->comments->count(),
            //'comments' => CommentResource::collection($this->comments), // load all the comments
            'tag_list' =>
                //'tags' => $this->tags //will output tags will all information
                $this->tagSlugs()
        ];
    }
}
