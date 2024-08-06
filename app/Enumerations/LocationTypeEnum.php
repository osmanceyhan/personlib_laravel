<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum LocationTypeEnum: string
{
    use EnumToArray;

    case AIRPORT = "AIRPORT";
    case CITY = "CITY";
    case DISTRICT = "DISTRICT";
    case UNDEFINED = "UNDEFINED";


    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "AIRPORT"    => "Havalimanı Ofisi",
            "CITY"   => "Şehir",
            "DISTRICT"   => "İlçe",
            "UNDEFINED"   => "Belirlenmemiş Lokasyon",
        };
    }

    static function getDetail($type): array
    {
        return match ($type)
        {
            "AIRPORT"    => [
                "key" => "AIRPORT", "value" => self::getStatus("AIRPORT"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("AIRPORT")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("AIRPORT")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("AIRPORT")]
                ]],
            "CITY"    => [
                "key" => "CITY", "value" => self::getStatus("CITY"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("CITY")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("CITY")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("CITY")]
                ]],
            "DISTRICT"    => [
                "key" => "DISTRICT", "value" => self::getStatus("DISTRICT"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("DISTRICT")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("DISTRICT")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("DISTRICT")]
                ]],
            "UNDEFINED"    => [
                "key" => "UNDEFINED", "value" => self::getStatus("UNDEFINED"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("UNDEFINED")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("UNDEFINED")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("UNDEFINED")]
                ]],

        };
    }

    /**
     * @return array[]
     */
    static function allStatus():array{
        return [
            [
                "key" => self::AIRPORT->name,
                "value" => self::getStatus(self::AIRPORT->name)
            ],
            [
                "key" => self::CITY->name,
                "value" => self::getStatus(self::CITY->name)
            ],
            [
                "key" => self::DISTRICT->name,
                "value" => self::getStatus(self::DISTRICT->name)
            ],
            [
                "key" => self::UNDEFINED->name,
                "value" => self::getStatus(self::UNDEFINED->name)
            ],
        ];
    }
}
