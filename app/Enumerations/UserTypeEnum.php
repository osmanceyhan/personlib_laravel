<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum UserTypeEnum: string
{
    use EnumToArray;

    case PERSONAL = "PERSONAL";
    case CORPORATE = "CORPORATE";


    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "PERSONAL"    => "Bireysel",
            "CORPORATE"   => "Kurumsal",
        };
    }

    static function getDetail($type): array
    {
        return match ($type)
        {
            "PERSONAL"    => [
                "key" => "PERSONAL", "value" => self::getStatus("PERSONAL"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("PERSONAL")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("PERSONAL")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("PERSONAL")]
                ]],
            "CORPORATE"    => [
                "key" => "CORPORATE", "value" => self::getStatus("CORPORATE"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","pending","text"),"background_color" => status_color("primary","pending","background"),"border"=>status_color("primary","pending","border"), 'desc' => self::getStatus("CORPORATE")],
                    "secondary"=> ["text_color"=>status_color("secondary","pending","text"),"background_color" => status_color("secondary","pending","background"),"border"=>status_color("secondary","pending","border"), 'desc' => self::getStatus("CORPORATE")]
                    , "default"=> ["text_color"=>status_color("default","pending","text"),"background_color" => status_color("default","pending","background"),"border"=>status_color("default","pending","border"), 'desc' => self::getStatus("CORPORATE")]
                ]],

        };
    }


    /**
     * @return array[]
     */
    static function allStatus():array{
        return [
            [
                "key" => self::PERSONAL->name,
                "value" => self::getStatus(self::PERSONAL->name)
            ],
            [
                "key" => self::CORPORATE->name,
                "value" => self::getStatus(self::CORPORATE->name)
            ]
        ];
    }
}
