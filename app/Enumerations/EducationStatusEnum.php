<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum EducationStatusEnum: string
{
    use EnumToArray;

    case STUDENT = "STUDENT";
    case GRADUATE = "GRADUATE";


    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "STUDENT" => "Öğrenci",
            "GRADUATE" => "Mezun",
            default => "Bilinmiyor"
        };
    }

    static function getDetail($type): array
    {
        return match ($type)
        {
            "GRADUATE"    => [
                "key" => "GRADUATE", "value" => self::getStatus("GRADUATE"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("GRADUATE")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("GRADUATE")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("GRADUATE")]
                ]],
            "STUDENT"    => [
                "key" => "STUDENT", "value" => self::getStatus("STUDENT"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","pending","text"),"background_color" => status_color("primary","pending","background"),"border"=>status_color("primary","pending","border"), 'desc' => self::getStatus("STUDENT")],
                    "secondary"=> ["text_color"=>status_color("secondary","pending","text"),"background_color" => status_color("secondary","pending","background"),"border"=>status_color("secondary","pending","border"), 'desc' => self::getStatus("STUDENT")]
                    , "default"=> ["text_color"=>status_color("default","pending","text"),"background_color" => status_color("default","pending","background"),"border"=>status_color("default","pending","border"), 'desc' => self::getStatus("STUDENT")]
                ]]

        };
    }


    /**
     * @return array[]
     */
    static function allStatus():array{
        return [
            [
                "key" => self::GRADUATE->name,
                "value" => self::getStatus(self::GRADUATE->name)
            ],
            [
                "key" => self::STUDENT->name,
                "value" => self::getStatus(self::STUDENT->name)
            ]
        ];
    }
}
