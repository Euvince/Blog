<?php

namespace App\Helpers;

class Text 
{
    public static function excerpt (string $content, $limit = 100): string
    {
        if (strlen($content) <= $limit)
        {
            return $content;
        }
        $last_space = mb_strpos($content, ' ', $limit);
        return mb_substr($content, 0, $last_space) .  '...';
    }
}