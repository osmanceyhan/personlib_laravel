<?php

namespace App\Http\Resources\Contents;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enumerations\BasicEnum;

class SliderResource extends JsonResource
{
    public function toArray($request)
    {


        if($this->sub_medias != null){
            $subMedias = array_map(function($item){
                $item['file'] = getCdn($item['file']);
                return $item;
            },json_decode(json_encode($this->sub_medias),true));
            $subMedias =  json_decode(json_encode($subMedias));

        }else{
            $subMedias = [];
        }

         return [
            // Customize the resource array based on your requirements
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'title' => $this->title,
            'sub_title' => $this->sub_title,
             'sub_medias' => $subMedias,
            'content' => $this->content,
            'image' => getCdn($this->image),
            'status' => BasicEnum::getDetail($this->status),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
