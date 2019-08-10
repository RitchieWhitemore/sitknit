<?php


namespace app\core\helpers;


class ColorHelper
{
    public static function getColors(int $length): array
    {
        $colors = [];
        for ($i = 0; $i < $length; $i++) {
            $colors[] = '#' . substr(md5(mt_rand()), 0, 6);
        }
        return $colors;
    }

    public static function getColor()
    {
        return '#' . substr(md5(mt_rand()), 0, 6);
    }
}