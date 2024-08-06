<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum MemberPermissionEnum: string
{
    use EnumToArray;

    case EMAIL = "EMAIL";
    case SMS = "SMS";
    case CAMPAIGN = "CAMPAIGN";



    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "EMAIL"    => "E-Posta",
            "SMS"   => "Sms",
            "CAMPAIGN"   => "Kampanya"
        };
    }

    static function getDetail($type): array
    {
        return match ($type)
        {
            "EMAIL"    => [
                "key" => "EMAIL", "value" => self::getStatus("EMAIL"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("EMAIL")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("EMAIL")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("EMAIL")]
                ]
            ],
            "SMS"    => [
                "key" => "SMS", "value" => self::getStatus("SMS"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("SMS")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("SMS")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("SMS")]
                ]
            ],
            "CAMPAIGN"    => [
                "key" => "CAMPAIGN", "value" => self::getStatus("CAMPAIGN"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("CAMPAIGN")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("CAMPAIGN")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("CAMPAIGN")]
                ]
            ],
        };
    }


    /**
     * @return array[]
     */
    static function allStatus():array{
        return [
            [
                "key" => self::EMAIL->name,
                "value" => self::getStatus(self::EMAIL->name)
            ],
            [
                "key" => self::SMS->name,
                "value" => self::getStatus(self::SMS->name)
            ],
            [
                "key" => self::CAMPAIGN->name,
                "value" => self::getStatus(self::CAMPAIGN->name)
            ]
        ];
    }
}
