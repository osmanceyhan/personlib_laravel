<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum ApprovalEnum: string
{
    use EnumToArray;

    case APPROVED = "APPROVED";
    case REJECTED = "REJECTED";
    case WAITING = "WAITING";


    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "APPROVED"    => "Onaylandı",
            "REJECTED"   => "Onaylanmadı",
            "WAITING"   => "Beklemede",
            default => "Bilinmiyor"
        };
    }

    static function getDetail($type): array
    {
        return match ($type)
        {
            "APPROVED"    => [
                "key" => "APPROVED", "value" => self::getStatus("APPROVED"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("APPROVED")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("APPROVED")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("APPROVED")]
                ]],
            "WAITING"    => [
                "key" => "WAITING", "value" => self::getStatus("WAITING"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","pending","text"),"background_color" => status_color("primary","pending","background"),"border"=>status_color("primary","pending","border"), 'desc' => self::getStatus("PENDING")],
                    "secondary"=> ["text_color"=>status_color("secondary","pending","text"),"background_color" => status_color("secondary","pending","background"),"border"=>status_color("secondary","pending","border"), 'desc' => self::getStatus("PENDING")]
                    , "default"=> ["text_color"=>status_color("default","pending","text"),"background_color" => status_color("default","pending","background"),"border"=>status_color("default","pending","border"), 'desc' => self::getStatus("PENDING")]
                ]],
            "REJECTED" =>[
                "key" => "REJECTED", "value" => self::getStatus("REJECTED"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","danger","text"),"background_color" => status_color("primary","danger","background"),"border"=>status_color("primary","danger","border"), 'desc' => self::getStatus("REJECTED")],
                    "secondary"=> ["text_color"=>status_color("secondary","danger","text"),"background_color" => status_color("secondary","danger","background"),"border"=>status_color("secondary","danger","border"), 'desc' => self::getStatus("REJECTED")],
                    "default"=> ["text_color"=>status_color("default","danger","text"),"background_color" => status_color("default","danger","background"),"border"=>status_color("default","danger","border"), 'desc' => self::getStatus("REJECTED")]
                ]]
        };
    }


    /**
     * @return array[]
     */
    static function allStatus():array{
        return [
            [
                "key" => self::APPROVED->name,
                "value" => self::getStatus(self::APPROVED->name)
            ],
            [
                "key" => self::REJECTED->name,
                "value" => self::getStatus(self::REJECTED->name)
            ]
        ];
    }
}
