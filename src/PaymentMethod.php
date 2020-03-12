<?php

namespace Wirecard\Credentials;

use Wirecard\Credentials\Exception\InvalidPaymentMethodException;

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
     * @param string $paymentMethod
     * @throws InvalidPaymentMethodException
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @since 1.0.0
     */
    public function __construct($paymentMethod)
    {
        if (!in_array($paymentMethod, PaymentMethodRegistry::availablePaymentMethods(), true)) {
            throw new InvalidPaymentMethodException($paymentMethod);
        }
        $this->value = $paymentMethod;
    }

    /**
     * @return string
     * @since 1.0.0
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * @param PaymentMethod $paymentMethod
     * @return bool
     * @since 1.0.0
     */
    public function equalsTo(PaymentMethod $paymentMethod)
    {
        return $this->value === $paymentMethod->value;
    }
}
