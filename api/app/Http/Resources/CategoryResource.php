<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CategoryResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'articles_count' => is_null($this->articles_count) ? 0 : $this->articles_count,
            'created_at_dates' => [
                'created_at_human' => $this->created_at->diffForHumans(),
                'created_at_format_1' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at),
                'created_at_format_2' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('M d Y h:i A'),
            ],
            'updated_at_dates' => [
                'updated_at_human' => $this->updated_at->diffForHumans(),
                'updated_at_format_1' => Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at),
                'updated_at_format_2' => Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('M d Y h:i A'),
            ]
        ];
    }
}
