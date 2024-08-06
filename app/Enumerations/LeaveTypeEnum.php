<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum LeaveTypeEnum: string
{
    use EnumToArray;

    case YEARLY = "Yıllık";
    case REQUEST = "Talep Başı";
    case NONLIMIT = "Limitsiz";


    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            self::YEARLY->name => "Yıllık",
            self::REQUEST->name => "Talep Başı",
            self::NONLIMIT->name => "Limitsiz",
            default => "Bilinmiyor",
        };
    }

    static function allStatus():array{
        return [
            self::YEARLY->name => "Yıllık",
            self::REQUEST->name => "Talep Başı",
            self::NONLIMIT->name => "Limitsiz",
        ];
    }

}
