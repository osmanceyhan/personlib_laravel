<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum PriceTypeEnum: string
{
    use EnumToArray;

    case FREE = "Ücretsiz";
    case PRICE = "Ücretli İzin";


    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            self::FREE->name => "Ücretsiz",
            self::PRICE->name => "Ücretli İzin",
            default => "Bilinmiyor",
        };
    }

    static function allStatus():array{
        return [
            self::FREE->name => "Ücretsiz",
            self::PRICE->name => "Ücretli İzin",
        ];
    }

}
