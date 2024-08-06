<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum NationalityEnum: string
{
    use EnumToArray;

    case TURKISH = "TURKISH";
    case OTHER = "OTHER";

    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "TURKISH"    => "Türk Vatandaşı",
            "OTHER"   => "Yabancı Vatandaş"
        };
    }

    static function getDetail($type): array
    {
        return match ($type)
        {
            "ACTIVE"    => [
                "key" => "TURKISH", "value" => self::getStatus("TURKISH"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("TURKISH")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("TURKISH")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("TURKISH")]
                ]],

            "NONVERIFY" =>[
                "key" => "OTHER", "value" => self::getStatus("OTHER"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","pending","text"),"background_color" => status_color("primary","pending","background"),"border"=>status_color("primary","pending","border"), 'desc' => self::getStatus("OTHER")],
                    "secondary"=> ["text_color"=>status_color("secondary","pending","text"),"background_color" => status_color("secondary","pending","background"),"border"=>status_color("secondary","pending","border"), 'desc' => self::getStatus("OTHER")],
                    "default"=> ["text_color"=>status_color("default","pending","text"),"background_color" => status_color("default","pending","background"),"border"=>status_color("default","pending","border"), 'desc' => self::getStatus("OTHER")]
                ]]
        };
    }


    /**
     * @return array[]
     */
    static function allStatus():array{
        return [
            [
                "key" => self::TURKISH->name,
                "value" => self::getStatus(self::TURKISH->name)
            ],
            [
                "key" => self::OTHER->name,
                "value" => self::getStatus(self::OTHER->name)
            ],
        ];
    }
}
