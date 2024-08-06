<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum MilitaryStatusEnum: string
{
    use EnumToArray;

    case DONE = "DONE";
    case POSTPONEMENT = "POSTPONEMENT";
    case LEAKAGE = "LEAKAGE";
    case EXEMPT = "EXEMPT";


    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "DONE" => "Yapıldı",
            "POSTPONEMENT" => "Erteleme",
            "LEAKAGE" => "Kaçak",
            "EXEMPT" => "Muafiyet",
            default => "Bilinmiyor"
        };
    }

    static function getDetail($type): array
    {
        return match ($type)
        {
            "DONE"    => [
                "key" => "DONE", "value" => self::getStatus("DONE"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("DONE")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("DONE")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("DONE")]
                ]],
            "EXEMPT"    => [
                "key" => "DONE", "value" => self::getStatus("EXEMPT"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("EXEMPT")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("EXEMPT")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("EXEMPT")]
                ]],
            "POSTPONEMENT"    => [
                "key" => "POSTPONEMENT", "value" => self::getStatus("POSTPONEMENT"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","pending","text"),"background_color" => status_color("primary","pending","background"),"border"=>status_color("primary","pending","border"), 'desc' => self::getStatus("POSTPONEMENT")],
                    "secondary"=> ["text_color"=>status_color("secondary","pending","text"),"background_color" => status_color("secondary","pending","background"),"border"=>status_color("secondary","pending","border"), 'desc' => self::getStatus("POSTPONEMENT")]
                    , "default"=> ["text_color"=>status_color("default","pending","text"),"background_color" => status_color("default","pending","background"),"border"=>status_color("default","pending","border"), 'desc' => self::getStatus("POSTPONEMENT")]
                ]],
            "LEAKAGE"    => [
                "key" => "LEAKAGE", "value" => self::getStatus("LEAKAGE"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","pending","text"),"background_color" => status_color("primary","pending","background"),"border"=>status_color("primary","pending","border"), 'desc' => self::getStatus("LEAKAGE")],
                    "secondary"=> ["text_color"=>status_color("secondary","pending","text"),"background_color" => status_color("secondary","pending","background"),"border"=>status_color("secondary","pending","border"), 'desc' => self::getStatus("LEAKAGE")]
                    , "default"=> ["text_color"=>status_color("default","pending","text"),"background_color" => status_color("default","pending","background"),"border"=>status_color("default","pending","border"), 'desc' => self::getStatus("LEAKAGE")]
                ]],

        };
    }


    /**
     * @return array[]
     */
    static function allStatus():array{
        return [
              [
                    "key" => self::DONE->name,
                    "value" => self::getStatus(self::DONE->name)
                ],
                [
                    "key" => self::POSTPONEMENT->name,
                    "value" => self::getStatus(self::POSTPONEMENT->name)
                ],
                [
                    "key" => self::LEAKAGE->name,
                    "value" => self::getStatus(self::LEAKAGE->name)
                ],
                [
                    "key" => self::EXEMPT->name,
                    "value" => self::getStatus(self::EXEMPT->name)
                ]
        ];
    }
}
