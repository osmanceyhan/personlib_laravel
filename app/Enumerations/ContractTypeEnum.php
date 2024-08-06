<?php

namespace App\Enumerations;

use App\Traits\Enum\EnumToArray;

enum ContractTypeEnum: string
{
    use EnumToArray;

    case INDEFINITE_CONTRACT = "INDEFINITE_CONTRACT";
    case TERM_CONTRACT = "TERM_CONTRACT";

    /**
     * @param $type
     * @return string
     */
    static function getStatus($type): string
    {
        return match ($type) {
            "INDEFINITE_CONTRACT" => "Belirsiz Süresiz Sözleşme",
            "TERM_CONTRACT" => "Belirli Süreli Sözleşme",
        };
    }

    static function getDetail($type): array
    {
        return match ($type)
        {
            "INDEFINITE_CONTRACT"    => [
                "key" => "INDEFINITE_CONTRACT", "value" => self::getStatus("INDEFINITE_CONTRACT"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("INDEFINITE_CONTRACT")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("INDEFINITE_CONTRACT")]
                    , "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("INDEFINITE_CONTRACT")]
                ]],
            "TERM_CONTRACT" =>[
                "key" => "TERM_CONTRACT", "value" => self::getStatus("TERM_CONTRACT"),
                "colors"=> [
                    "primary"=> ["text_color"=>status_color("primary","success","text"),"background_color" => status_color("primary","success","background"),"border"=>status_color("primary","success","border"), 'desc' => self::getStatus("TERM_CONTRACT")],
                    "secondary"=> ["text_color"=>status_color("secondary","success","text"),"background_color" => status_color("secondary","success","background"),"border"=>status_color("secondary","success","border"), 'desc' => self::getStatus("TERM_CONTRACT")],
                    "default"=> ["text_color"=>status_color("default","success","text"),"background_color" => status_color("default","success","background"),"border"=>status_color("default","success","border"), 'desc' => self::getStatus("TERM_CONTRACT")]
                ]],
        };
    }


    /**
     * @return array[]
     */
    static function allStatus():array{
        return [
            [
                "key" => self::INDEFINITE_CONTRACT->name,
                "value" => self::getStatus(self::INDEFINITE_CONTRACT->name)
            ],
            [
                "key" => self::TERM_CONTRACT->name,
                "value" => self::getStatus(self::TERM_CONTRACT->name)
            ],
        ];
    }
}
