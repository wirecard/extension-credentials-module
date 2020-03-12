<?php


namespace CredentialsTest\Exception;

use Credentials\PaymentMethodRegistry;
use PHPUnit\Framework\TestCase;
use Credentials\Exception\InvalidPaymentMethodException;

/**
 * Class InvalidPaymentMethodExceptionTest
 * @package CredentialsTest\Exception
 * @coversDefaultClass \Credentials\Exception\InvalidPaymentMethodException
 * @since 1.0.0
 */
class InvalidPaymentMethodExceptionTest extends TestCase
{
    /**
     * @group unit
     * @small
     * @throws InvalidPaymentMethodException
     */
    public function testInvalidPaymentMethodException()
    {
        $this->expectException(InvalidPaymentMethodException::class);
        $this->expectExceptionMessage("Invalid or unsupported payment method creditcard");
        throw new InvalidPaymentMethodException(PaymentMethodRegistry::TYPE_CREDIT_CARD);
    }
}