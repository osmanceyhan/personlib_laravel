<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum ProductsEnum: string
{
    use EnumToArray;

    case DAILY = "DAILY";
    case TOTAL = "TOTAL";

    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type) {
            "DAILY" => "Günlük Ücretlendirme",
            "TOTAL" => "Toplam Ücretlendirme"
        };
    }

    static function getDetail($type): array
    {
        return match ($type)
        {
            "DAILY"    => [
                "key" => "DAILY", "value" => self::getStatus("DAILY"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("DAILY")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("DAILY")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("DAILY")]
                ]],
            "TOTAL" =>[
                "key" => "TOTAL", "value" => self::getStatus("TOTAL"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("TOTAL")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("TOTAL")],
                    "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("TOTAL")]
                ]],
        };
    }


    /**
     * @return array[]
     */
    static function allStatus():array{
        return [
            [
                "key" => self::DAILY->name,
                "value" => self::getStatus(self::DAILY->name)
            ],
            [
                "key" => self::TOTAL->name,
                "value" => self::getStatus(self::TOTAL->name)
            ],
        ];
    }
}
