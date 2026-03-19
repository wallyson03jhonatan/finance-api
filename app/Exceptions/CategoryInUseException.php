<?php

namespace App\Exceptions;

use Exception;

class CategoryInUseException extends Exception
{
    public function __construct()
    {
        parent::__construct('Esta categoria está vinculada a uma ou mais transações e não pode ser removida.');
    }
}
