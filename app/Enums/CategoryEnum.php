<?php

namespace App\Enums;

enum CategoryEnum: string
{
    case DIGITAL = "DIGITAL";
    case PHYSICAL = "PHYSICAL";

    public static function randomValue(): string
    {
        $arr = array_column(self::cases(), 'value');

        return $arr[array_rand($arr)];
    }

    public static function getStrings(): string
    {
        return implode(',', self::cases());
    }
}
