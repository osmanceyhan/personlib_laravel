<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum MaritalStatusEnum: string
{
    use EnumToArray;

    case MARRIED = "MARRIED";
    case SINGLE = "SINGLE";


    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "MARRIED" => "Evli",
            "SINGLE" => "Bekar",
            default => "Bilinmiyor"
        };
    }

    static function getDetail($type): array
    {
        return match ($type)
        {
            "MARRIED"    => [
                "key" => "MARRIED", "value" => self::getStatus("MARRIED"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("MARRIED")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("MARRIED")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("MARRIED")]
                ]],
            "SINGLE"    => [
                "key" => "SINGLE", "value" => self::getStatus("SINGLE"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","pending","text"),"background_color" => status_color("primary","pending","background"),"border"=>status_color("primary","pending","border"), 'desc' => self::getStatus("SINGLE")],
                    "secondary"=> ["text_color"=>status_color("secondary","pending","text"),"background_color" => status_color("secondary","pending","background"),"border"=>status_color("secondary","pending","border"), 'desc' => self::getStatus("SINGLE")]
                    , "default"=> ["text_color"=>status_color("default","pending","text"),"background_color" => status_color("default","pending","background"),"border"=>status_color("default","pending","border"), 'desc' => self::getStatus("SINGLE")]
                ]]

        };
    }


    /**
     * @return array[]
     */
    static function allStatus():array{
        return [
            [
                "key" => self::MARRIED->name,
                "value" => self::getStatus(self::MARRIED->name)
            ],
            [
                "key" => self::SINGLE->name,
                "value" => self::getStatus(self::SINGLE->name)
            ]
        ];
    }
}
