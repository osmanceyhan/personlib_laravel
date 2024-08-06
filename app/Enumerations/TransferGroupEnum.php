<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum TransferGroupEnum: string
{
    use EnumToArray;

    case PRIVATE = "PRIVATE";
    case SHUTTLE = "SHUTTLE";


    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "PRIVATE"   => "Özel Araç",
            "SHUTTLE"    => "Servis Aracı"
        };
    }

    static function getDetail($type): array
    {
        return match ($type)
        {
            "PRIVATE"    => [
                "key" => "PRIVATE", "value" => self::getStatus("PRIVATE"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("PRIVATE")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("PRIVATE")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("PRIVATE")]
                ]],
            "SHUTTLE"    => [
                "key" => "SHUTTLE", "value" => self::getStatus("SHUTTLE"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("SHUTTLE")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("SHUTTLE")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("SHUTTLE")]
                ]],

        };
    }

    /**
     * @return array[]
     */
    static function allStatus():array{
        return [
            [
                "key" => self::PRIVATE->name,
                "value" => self::getStatus(self::PRIVATE->name)
            ],
            [
                "key" => self::SHUTTLE->name,
                "value" => self::getStatus(self::SHUTTLE->name)
            ]
        ];
    }
}
