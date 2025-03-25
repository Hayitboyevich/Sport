<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($code = 500, $message = "Invalid file type")
    {
        $this->message = $message;
        $this->code = $code;
        parent::__construct($message, $code);
    }
}
