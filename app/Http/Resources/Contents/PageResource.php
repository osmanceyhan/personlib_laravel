<?php

namespace App\Http\Resources\Contents;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enumerations\BasicEnum;
use Carbon\Carbon;
class PageResource extends JsonResource
{
    public function toArray($request)
    {
         return [
            // Customize the resource array based on your requirements
            'id' => $this->id,
             'title' => $this->title,
             'sub_title' => $this->sub_title,
             'slug' => $this->slug,
            'category_id' => $this->category_id,
             'category' => $this->category,
             'featured_title' => $this->featured_title,
             'featured_desc' => $this->featured_desc,
             'featured_image' => getCdn($this->featured_image),
            'cover_image' => getCdn($this->cover_image),
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'content' => $this->content,
            'status' => BasicEnum::getDetail($this->status),
             'created_at' => Carbon::parse($this->created_at)->format('j F Y H:i'),
        ];
    }
}
