<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum UsersEnum: string
{
    use EnumToArray;

    case ACTIVE = "ACTIVE";
    case PASSIVE = "PASSIVE";
    case NONVERIFY = "NONVERIFY";
    case CANCELLED = "CANCELLED";
    case DEMO = "DEMO";
    case BANNED = "BANNED";

    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type)
        {
            "ACTIVE"    => "Aktif",
            "PASSIVE"   => "Pasif",
            "NONVERIFY"   => "Onay Bekliyor",
            "CANCELLED"   => "İptal Edilmiş",
            "DEMO"   => "Demo Hesap",
            "BANNED"  => "Yasaklı Üye"
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
                "key" => self::NONVERIFY->name,
                "value" => self::getStatus(self::NONVERIFY->name)
            ],
            [
                "key" => self::CANCELLED->name,
                "value" => self::getStatus(self::CANCELLED->name)
            ],
            [
                "key" => self::DEMO->name,
                "value" => self::getStatus(self::DEMO->name)
            ],
            [
                "key" => self::BANNED->name,
                "value" => self::getStatus(self::BANNED->name)
            ]
        ];
    }
}
