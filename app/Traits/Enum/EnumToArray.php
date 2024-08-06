<?php

namespace App\Traits\Enum;

use Illuminate\Support\Carbon;

trait EnumToArray
{

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::names(), self::values());
    }

    public static function reverseArray(): array
    {
        return array_combine(self::values(), self::names());
    }

    /**
     * @param $type
     * @return string[]
     */
    public static function colors($type = 'disabled')
    {
        $colors = [
            'success' => [
                "title_color" => '#121212',
                "sub_title_color"=> '#ACACAC',
                "description_color"=> '#5B5B5B',
                "circle_color"=>  '#6CA538',
                "circle_opacity_color"=> '#E2EED8',
                "border_line_color"=> '#D1D1D1',
            ],
            'active' => [
                "title_color" => '#121212',
                "sub_title_color"=> '#0096B5',
                "description_color"=> '#5B5B5B',
                "circle_color"=>  '#FCBB07',
                "circle_opacity_color"=> '#FEF2D8',
                "border_line_color"=> '#D1D1D1',
            ],
            'disabled' => [
                "title_color" => '#888888',
                "sub_title_color"=> '#ACACAC',
                "description_color"=> '#5B5B5B',
                "circle_color"=>  '#484848',
                "circle_opacity_color"=> '#E9E9E9',
                "border_line_color"=> '#D1D1D1',
            ],
        ];
        return $colors[$type];
    }

    /**
     * @return array
     */
    public static function getForApi():array
    {
        $result = [];
        foreach (self::getString()->toArray() as $key => $item) {
            $result[] = ['key' => $key, 'value' => $item];
        }
        return $result;
    }


    public static function textWithArray(): array
    {
        $result = [];
        foreach (self::array() as $key => $item) {
            $result[$key] = __($item);
        }
        return $result;
    }


}
