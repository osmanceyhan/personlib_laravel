<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum SliderTypeEnum: string
{
    use EnumToArray;

    case HOME = "HOME";
    case HOME_SEARCH = "HOME_SEARCH";


    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "HOME"    => "Anasayfa",
            "HOME_SEARCH" => "Anasayfa Arama Alanı"
        };
    }

    static function allStatus():array{
        return [
            [
                "key" => self::HOME->name,
                "value" => self::getStatus(self::HOME->name)
            ],
            [
                "key" => self::HOME_SEARCH->name,
                "value" => self::getStatus(self::HOME_SEARCH->name)
            ]
        ];
    }

}
