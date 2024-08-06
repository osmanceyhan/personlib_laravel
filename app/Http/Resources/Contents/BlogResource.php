<?php

namespace App\Http\Resources\Contents;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enumerations\BasicEnum;
use Carbon\Carbon;
class BlogResource extends JsonResource
{
    public function toArray($request)
    {
         return [
            // Customize the resource array based on your requirements
            'id' => $this->id,
            'small_title' => $this->small_title,
            'title' => $this->title,
            'slug' => $this->slug,
            'category_id' => $this->category_id,
             'category' => $this->category,
            'sub_category_id' => $this->sub_category_id,
            'description' => $this->description,
            'featured_image' => getCdn($this->featured_image),
            'cover_image' => getCdn($this->cover_image),
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'content_index' => $this->content_index,
            'content' => $this->content,
            'hit' => $this->hit,
            'tags' => $this->hit,
            'editor_choose' => $this->hit,
            'status' => BasicEnum::getDetail($this->status),
             'published_at' => Carbon::parse($this->published_at)->format('j F Y H:i'),
             'created_at' => Carbon::parse($this->created_at)->format('j F Y H:i'),
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
