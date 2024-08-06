<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum CompletedEnum: string
{
    use EnumToArray;

    case ACTIVE = "ACTIVE";
    case PASSIVE = "PASSIVE";

    case COMPLETED = "COMPLETED"
    ;

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
            "COMPLETED"  => "TAMAMLANDI"
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
            "COMPLETED" =>[
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
                "key" => self::COMPLETED->name,
                "value" => self::getStatus(self::COMPLETED->name)
            ]
        ];
    }
}
