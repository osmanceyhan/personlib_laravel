<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_type' => $this->user_type,
            'name' => $this->name,
            'surname' => $this->surname,
            'token' => $this->token,
            'email' => $this->email,
            'verify_token' => $this->verify_token,
            'email_verified_at' => $this->email_verified_at,
            'birthday' => $this->birthday,
            'country' => $this->getCountry,
            'country_id' => $this->country_id,
            'geo_code' => $this->geo_code,
            'geo_value' => $this->getGeoCode->value,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'is_tc' => $this->is_tc,
            'tc_no' => $this->tc_no,
            'passaport_no' => $this->passaport_no,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
