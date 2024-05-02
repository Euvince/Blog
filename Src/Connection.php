<?php

namespace App;

use PDO;

class Connection
{
    public static function getPDO (): PDO
    {
        return new PDO('mysql:dbname=BlogReprise;host=127.0.0.1:3303', 'Euvince', 'Euvince', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }
}