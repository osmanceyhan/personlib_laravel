<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum DiscountTypeEnum: string
{
    use EnumToArray;

    case PERCENTAGE = "PERCENTAGE";
    case AMOUNT = "AMOUNT";
    case DAY = "DAY";


    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "PERCENTAGE"    => "Yüzde (%) İndirimi",
            "AMOUNT"   => "Tutar İndirimi",
            "DAY"   => "Gün İndirimi",
        };
    }

    static function getDetail($type): array
    {
        return match ($type)
        {
            "PERCENTAGE"    => [
                "key" => "PERCENTAGE", "value" => self::getStatus("PERCENTAGE"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("PERCENTAGE")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("PERCENTAGE")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("PERCENTAGE")]
                ]],
            "AMOUNT" =>[
                "key" => "AMOUNT", "value" => self::getStatus("AMOUNT"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","pending","text"),"background_color" => status_color("primary","pending","background"),"border"=>status_color("primary","pending","border"), 'desc' => self::getStatus("AMOUNT")],
                    "secondary"=> ["text_color"=>status_color("secondary","pending","text"),"background_color" => status_color("secondary","pending","background"),"border"=>status_color("secondary","pending","border"), 'desc' => self::getStatus("AMOUNT")],
                    "default"=> ["text_color"=>status_color("default","pending","text"),"background_color" => status_color("default","pending","background"),"border"=>status_color("default","pending","border"), 'desc' => self::getStatus("AMOUNT")]
                ]],
            "DAY"    => [
                "key" => "DAY", "value" => self::getStatus("DAY"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("DAY")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("DAY")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("DAY")]
                ]],
        };
    }


    /**
     * @return array[]
     */
    static function allStatus():array{
        return [
            [
                "key" => self::PERCENTAGE->name,
                "value" => self::getStatus(self::PERCENTAGE->name)
            ],
            [
                "key" => self::AMOUNT->name,
                "value" => self::getStatus(self::AMOUNT->name)
            ],
            [
                "key" => self::DAY->name,
                "value" => self::getStatus(self::DAY->name)
            ]
        ];
    }
}
