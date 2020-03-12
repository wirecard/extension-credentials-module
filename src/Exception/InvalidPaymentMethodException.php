<?php

namespace Wirecard\Credentials\Exception;

use Exception;
use Throwable;

/**
 * Class InvalidPaymentMethodException
 * @package Credentials\Exception
 * @since 1.0.0
 */
class InvalidPaymentMethodException extends Exception
{
    /**
     * InvalidPaymentMethodException constructor.
     * @param string $paymentMethod
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @since 1.0.0
     */
    public function __construct($paymentMethod, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->message = $message ?: "Invalid or unsupported payment method {$paymentMethod}";
        parent::__construct($this->message, $code, $previous);
    }
}
