<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum PerTypeEnum: string
{
    use EnumToArray;

    case PERSON = "PERSON";
    case VEHICLE = "VEHICLE";


    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "PERSON"    => "Kişi Başı",
            "VEHICLE" => "Araç Başı"
        };
    }
    /**
     * @param $type
     * @return string
     */
    static function getStatusEnglish($type): string
    {
        return match ($type)
        {
            "PERSON"    => "Number of People",
            "VEHICLE" => "Number of Vehicles"
        };
    }
    /**
     * @param $type
     * @return string
     */
    static function getStatusEnglishPerType($type): string
    {
        return match ($type)
        {
            "PERSON"    => "Per Person",
            "VEHICLE" => "Per Vehicle"
        };
    }



    /**
     * @param $type
     * @return string
     */
    static function getStatusEnglishPlaceholder($type): string
    {
        return match ($type)
        {
            "PERSON"    => "Please select people count",
            "VEHICLE" => "Please select vehicle count"
        };
    }


    static function allStatus():array{
        return [
            [
                "key" => self::PERSON->name,
                "value" => self::getStatus(self::PERSON->name)
            ],
            [
                "key" => self::VEHICLE->name,
                "value" => self::getStatus(self::VEHICLE->name)
            ]
        ];
    }

}
