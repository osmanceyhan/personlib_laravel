<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum ReservationsEnum: string
{
    use EnumToArray;

    case COMPLETED = "COMPLETED";
    case WAITING = "WAITING";
    case FAILED = "FAILED";
    case CANCELLED = "CANCELLED";


    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "COMPLETED"    => "Başarılı",
            "FAILED"   => "İşlem Hatası",
            "CANCELLED"   => "İptal Edildi",
            "WAITING"   => "Ödeme Beklemede"
        };
    }

    static function getDetail($type): array
    {
        return match ($type)
        {
            "COMPLETED"    => [
                "key" => "COMPLETED", "value" => self::getStatus("COMPLETED"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("COMPLETED")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("COMPLETED")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("COMPLETED")]
                ]],
            "FAILED" =>[
                "key" => "FAILED", "value" => self::getStatus("FAILED"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","danger","text"),"background_color" => status_color("primary","danger","background"),"border"=>status_color("primary","danger","border"), 'desc' => self::getStatus("FAILED")],
                    "secondary"=> ["text_color"=>status_color("secondary","danger","text"),"background_color" => status_color("secondary","danger","background"),"border"=>status_color("secondary","danger","border"), 'desc' => self::getStatus("FAILED")],
                    "default"=> ["text_color"=>status_color("default","danger","text"),"background_color" => status_color("default","danger","background"),"border"=>status_color("default","danger","border"), 'desc' => self::getStatus("FAILED")]
                ]],
            "CANCELLED" =>[
                "key" => "CANCELLED", "value" => self::getStatus("CANCELLED"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","danger","text"),"background_color" => status_color("primary","danger","background"),"border"=>status_color("primary","danger","border"), 'desc' => self::getStatus("CANCELLED")],
                    "secondary"=> ["text_color"=>status_color("secondary","danger","text"),"background_color" => status_color("secondary","danger","background"),"border"=>status_color("secondary","danger","border"), 'desc' => self::getStatus("CANCELLED")],
                    "default"=> ["text_color"=>status_color("default","danger","text"),"background_color" => status_color("default","danger","background"),"border"=>status_color("default","danger","border"), 'desc' => self::getStatus("CANCELLED")]
                ]],
            "WAITING" =>[
                "key" => "WAITING", "value" => self::getStatus("WAITING"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","pending","text"),"background_color" => status_color("primary","pending","background"),"border"=>status_color("primary","pending","border"), 'desc' => self::getStatus("WAITING")],
                    "secondary"=> ["text_color"=>status_color("secondary","pending","text"),"background_color" => status_color("secondary","pending","background"),"border"=>status_color("secondary","pending","border"), 'desc' => self::getStatus("WAITING")],
                    "default"=> ["text_color"=>status_color("default","pending","text"),"background_color" => status_color("default","pending","background"),"border"=>status_color("default","pending","border"), 'desc' => self::getStatus("WAITING")]
                ]]
        };
    }


    /**
     * @return array[]
     */
    static function allStatus():array{
        return [
            [
                "key" => self::ACTIVE->name,
                "value" => self::getStatus(self::ACTIVE->name)
            ],
            [
                "key" => self::FAILED->name,
                "value" => self::getStatus(self::FAILED->name)
            ],
            [
                "key" => self::CANCELLED->name,
                "value" => self::getStatus(self::CANCELLED->name)
            ],
            [
                "key" => self::WAITING->name,
                "value" => self::getStatus(self::WAITING->name)
            ]
        ];
    }
}
