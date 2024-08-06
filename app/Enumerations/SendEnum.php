<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum SendEnum: string
{
    use EnumToArray;

    case SEND = "SEND";
    case NOSEND = "NOSEND";

    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "SEND"    => "Gönder",
            "NOSEND"   => "Gönderme"
        };
    }

    static function getDetail($type): array
    {
        return match ($type)
        {
            "SEND"    => [
                "key" => "SEND", "value" => self::getStatus("SEND"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("SEND")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("SEND")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("SEND")]
                ]],
            "NOSEND" =>[
                "key" => "NOSEND", "value" => self::getStatus("NOSEND"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","danger","text"),"background_color" => status_color("primary","danger","background"),"border"=>status_color("primary","danger","border"), 'desc' => self::getStatus("NOSEND")],
                    "secondary"=> ["text_color"=>status_color("secondary","danger","text"),"background_color" => status_color("secondary","danger","background"),"border"=>status_color("secondary","danger","border"), 'desc' => self::getStatus("NOSEND")],
                    "default"=> ["text_color"=>status_color("default","danger","text"),"background_color" => status_color("default","danger","background"),"border"=>status_color("default","danger","border"), 'desc' => self::getStatus("NOSEND")]
                ]]
        };
    }


    /**
     * @return array[]
     */
    static function allStatus():array{
        return [
            [
                "key" => self::SEND->name,
                "value" => self::getStatus(self::SEND->name)
            ],
            [
                "key" => self::NOSEND->name,
                "value" => self::getStatus(self::NOSEND->name)
            ]
        ];
    }
}
