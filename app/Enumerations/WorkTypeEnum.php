<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum WorkTypeEnum: string
{
    use EnumToArray;

    case PART_TIME = "PART_TIME";
    case FULL_TIME = "FULL_TIME";


    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "PART_TIME"    => "Yarı Zamanlı",
            "FULL_TIME"   => "Tam Zamanlı"
        };
    }

    static function getDetail($type): array
    {
        return match ($type)
        {
            "PART_TIME"    => [
                "key" => "PART_TIME", "value" => self::getStatus("PART_TIME"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("PART_TIME")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("PART_TIME")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("PART_TIME")]
                ]],
            "FULL_TIME"    => [
                "key" => "FULL_TIME", "value" => self::getStatus("FULL_TIME"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("FULL_TIME")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("FULL_TIME")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("FULL_TIME")]
                ]],
        };
    }


    /**
     * @return array[]
     */
    static function allStatus():array{
        return [
            [
                "key" => self::PART_TIME->name,
                "value" => self::getStatus(self::PART_TIME->name)
            ],
            [
                "key" => self::FULL_TIME->name,
                "value" => self::getStatus(self::FULL_TIME->name)
            ]
        ];
    }
}
