<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //the resources such as 'id' & etc will be available to here from the constructor "public function __construct($resource)" of the JsonResource extended above
        return [
            'name' => $this->name,
            'created_date' => [
                'created_human' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at
            ],
            'articles' => ArticleResource::collection($this->whenLoaded('articles')),
            'formatted_address' => $this->formatted_address,
            'tagline' => $this->tagline,
            'about' => $this->about,
            'location' => $this->location
        ];
    }
}
