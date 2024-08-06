<?php

namespace App\Http\Resources\Settings;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sort' => $this->sort,
            'key' => $this->key,
            'description' => $this->description,
            'type' => $this->type,
            'group_class' => $this->group_class,
            'title' => $this->title,
            'value' => $this->value,
            'fields' => json_decode($this->fields),
            'status' => $this->status
        ];
    }

}
