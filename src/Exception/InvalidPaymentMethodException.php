<?php

namespace CredentialsReader\Exception;

use Exception;
use Throwable;

class InvalidPaymentMethodException extends Exception
{
    public function __construct($paymentMethod, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->message = $message ?: "Invalid or unsupported payment method {$paymentMethod}";
        parent::__construct($this->message, $code, $previous);
    }
}
