<?php

namespace Credentials\Exception;

use Exception;
use Throwable;

class MissedCredentialsException extends Exception
{
    public function __construct($fields, $message = "", $code = 0, Throwable $previous = null)
    {
        $message .= "Following fields: [" . implode(", ", $fields) . "] are required!";
        parent::__construct($message, $code, $previous);
    }
}
