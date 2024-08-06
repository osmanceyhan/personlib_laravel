<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum EducationCompleteStatusEnum: string
{
    use EnumToArray;


    case PRIMARY_SCHOOL = "PRIMARY_SCHOOL";
    case MIDDLE_SCHOOL = "MIDDLE_SCHOOL";
    case HIGH_SCHOOL = "HIGH_SCHOOL";
    case ASSOCIATE_DEGREE = "ASSOCIATE_DEGREE";
    case UNIVERSITY = "UNIVERSITY";
    case DOCTORATE = "DOCTORATE";


    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "PRIMARY_SCHOOL" => "İlkokul",
            "MIDDLE_SCHOOL" => "Ortaokul",
            "HIGH_SCHOOL" => "Lise",
            "ASSOCIATE_DEGREE" => "Ön Lisans",
            "UNIVERSITY" => "Lisans",
            "DOCTORATE" => "Doktora",
            default => "Bilinmiyor"
        };
    }

    static function getDetail($type): array
    {
        return match ($type)
        {
            "PRIMARY_SCHOOL"    => [
                "key" => "PRIMARY_SCHOOL", "value" => self::getStatus("PRIMARY_SCHOOL"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("PRIMARY_SCHOOL")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("PRIMARY_SCHOOL")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("PRIMARY_SCHOOL")]
                ]],
            "MIDDLE_SCHOOL"    => [
                "key" => "MIDDLE_SCHOOL", "value" => self::getStatus("MIDDLE_SCHOOL"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("MIDDLE_SCHOOL")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("MIDDLE_SCHOOL")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("MIDDLE_SCHOOL")]
                ]],
            "HIGH_SCHOOL"    => [
                "key" => "HIGH_SCHOOL", "value" => self::getStatus("HIGH_SCHOOL"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("HIGH_SCHOOL")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("HIGH_SCHOOL")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("HIGH_SCHOOL")]
                ]],
            "ASSOCIATE_DEGREE"    => [
                "key" => "ASSOCIATE_DEGREE", "value" => self::getStatus("ASSOCIATE_DEGREE"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("ASSOCIATE_DEGREE")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("ASSOCIATE_DEGREE")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("ASSOCIATE_DEGREE")]
                ]],
            "UNIVERSITY"    => [
                "key" => "UNIVERSITY", "value" => self::getStatus("UNIVERSITY"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("UNIVERSITY")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("UNIVERSITY")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("UNIVERSITY")]
                ]],
            "DOCTORATE"    => [
                "key" => "DOCTORATE", "value" => self::getStatus("DOCTORATE"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("DOCTORATE")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("DOCTORATE")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("DOCTORATE")]
                ]],

        };
    }


    /**
     * @return array[]
     */
    static function allStatus():array{
        return [
            [
                "key" => self::PRIMARY_SCHOOL->name,
                "value" => self::getStatus(self::PRIMARY_SCHOOL->name)
            ],
            [
                "key" => self::MIDDLE_SCHOOL->name,
                "value" => self::getStatus(self::MIDDLE_SCHOOL->name)
            ],
            [
                "key" => self::HIGH_SCHOOL->name,
                "value" => self::getStatus(self::HIGH_SCHOOL->name)
            ],
            [
                "key" => self::ASSOCIATE_DEGREE->name,
                "value" => self::getStatus(self::ASSOCIATE_DEGREE->name)
            ],
            [
                "key" => self::UNIVERSITY->name,
                "value" => self::getStatus(self::UNIVERSITY->name)
            ],
            [
                "key" => self::DOCTORATE->name,
                "value" => self::getStatus(self::DOCTORATE->name)
            ]
        ];
    }
}
