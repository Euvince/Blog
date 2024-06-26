<?php

namespace App\Table\Exception;

use Exception;

class NotFoundException extends Exception
{
    public function __construct(string $table, $id)
    {
        $this->message = "Aucune enrégistrement ne correspond à l'id #$id dans la table '$table'";
    }
}