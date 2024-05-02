<?php

namespace App;

class Helper
{
    public static function e (string $string): string
    {
        return htmlentities($string);
    }
}