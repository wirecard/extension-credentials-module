<?php

namespace Credentials;

use Credentials\Exception\InvalidPaymentMethodException;

/**
 * Class PaymentMethod
 * @package Credentials
 * @since 1.0.0
 */
class PaymentMethod
{
    /**
     * @var string
     */
    private $value;

    /**
     * PaymentMethod constructor.
     * @param $paymentMethod
     * @throws InvalidPaymentMethodException
     * @since 1.0.0
     */
    public function __construct($paymentMethod, PaymentMethodRegistry $registry)
    {
        if (!in_array($paymentMethod, $registry->availablePaymentMethods())) {
            throw new InvalidPaymentMethodException($paymentMethod);
        }
        $this->value = $paymentMethod;
    }

    /**
     * @return string
     * @since 1.0.0
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     * @since 1.0.0
     */
    public function __toString()
    {
        return $this->getValue();
    }

    /**
     * @param $value
     * @return bool
     * @since 1.0.0
     */
    public function equalsTo($value)
    {
        return $this->getValue() === $value;
    }
}
