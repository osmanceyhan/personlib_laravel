<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum BasicEnum: string
{
    use EnumToArray;

    case ACTIVE = "ACTIVE";
    case PASSIVE = "PASSIVE";
    case PENDING = "PENDING";
    case WAITING = "WAITING";
    case COMPLETE = "COMPLETE";
    case DEMO = "DEMO";

    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "ACTIVE"    => "AKTİF",
            "PASSIVE"   => "PASİF",
            "WAITING"   => "BEKLENİYOR",
            "PENDING"   => "ONAY BEKLİYOR",
            "COMPLETE"  => "TAMAMLANDI",
            "DEMO"      => "DEMO",
            default     => "Bilinmeyen"
        };
    }

    static function getDetail($type): array
    {
        return match ($type)
        {
            "ACTIVE"    => [
                "key" => "ACTIVE", "value" => self::getStatus("ACTIVE"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("ACTIVE")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("ACTIVE")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("ACTIVE")]
                ]],
            "PASSIVE" =>[
                "key" => "PASSIVE", "value" => self::getStatus("PASSIVE"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","danger","text"),"background_color" => status_color("primary","danger","background"),"border"=>status_color("primary","danger","border"), 'desc' => self::getStatus("PASSIVE")],
                    "secondary"=> ["text_color"=>status_color("secondary","danger","text"),"background_color" => status_color("secondary","danger","background"),"border"=>status_color("secondary","danger","border"), 'desc' => self::getStatus("PASSIVE")],
                    "default"=> ["text_color"=>status_color("default","danger","text"),"background_color" => status_color("default","danger","background"),"border"=>status_color("default","danger","border"), 'desc' => self::getStatus("PASSIVE")]
                ]],
            "WAITING" =>[
                "key" => "WAITING", "value" => self::getStatus("WAITING"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","pending","text"),"background_color" => status_color("primary","pending","background"),"border"=>status_color("primary","pending","border"), 'desc' => self::getStatus("WAITING")],
                    "secondary"=> ["text_color"=>status_color("secondary","pending","text"),"background_color" => status_color("secondary","pending","background"),"border"=>status_color("secondary","pending","border"), 'desc' => self::getStatus("WAITING")],
                    "default"=> ["text_color"=>status_color("default","pending","text"),"background_color" => status_color("default","pending","background"),"border"=>status_color("default","pending","border"), 'desc' => self::getStatus("WAITING")]
                ]],
            "DEMO" =>[
                "key" => "DEMO", "value" => self::getStatus("DEMO"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","pending","text"),"background_color" => status_color("primary","pending","background"),"border"=>status_color("primary","pending","border"), 'desc' => self::getStatus("DEMO")],
                    "secondary"=> ["text_color"=>status_color("secondary","pending","text"),"background_color" => status_color("secondary","pending","background"),"border"=>status_color("secondary","pending","border"), 'desc' => self::getStatus("DEMO")],
                    "default"=> ["text_color"=>status_color("default","pending","text"),"background_color" => status_color("default","pending","background"),"border"=>status_color("default","pending","border"), 'desc' => self::getStatus("DEMO")]
                ]],
            "PENDING" =>[
                "key" => "PENDING", "value" => self::getStatus("PENDING"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","pending","text"),"background_color" => status_color("primary","pending","background"),"border"=>status_color("primary","pending","border"), 'desc' => self::getStatus("PENDING")],
                    "secondary"=> ["text_color"=>status_color("secondary","pending","text"),"background_color" => status_color("secondary","pending","background"),"border"=>status_color("secondary","pending","border"), 'desc' => self::getStatus("PENDING")],
                    "default"=> ["text_color"=>status_color("default","pending","text"),"background_color" => status_color("default","pending","background"),"border"=>status_color("default","pending","border"), 'desc' => self::getStatus("PENDING")]
                ]],
            "COMPLETE" =>[
                "key" => "COMPLETE", "value" => self::getStatus("COMPLETE"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("COMPLETE")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("COMPLETE")],
                    "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("COMPLETE")]
                ]],
        };
    }

    /**
     * @return array[]
     */
    static function basicStatus():array{
        return [
            [
                "key" => self::ACTIVE->name,
                "value" => self::getStatus(self::ACTIVE->name)
            ],
            [
                "key" => self::PASSIVE->name,
                "value" => self::getStatus(self::PASSIVE->name)
            ]
        ];
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
                "key" => self::PASSIVE->name,
                "value" => self::getStatus(self::PASSIVE->name)
            ],
            [
                "key" => self::PENDING->name,
                "value" => self::getStatus(self::PENDING->name)
            ],
            [
                "key" => self::DEMO->name,
                "value" => self::getStatus(self::DEMO->name)
            ],
            [
                "key" => self::WAITING->name,
                "value" => self::getStatus(self::WAITING->name)
            ],
            [
                "key" => self::COMPLETE->name,
                "value" => self::getStatus(self::COMPLETE->name)
            ]
        ];
    }
}
