<?php

namespace CredentialsTest\Constants;

use Credentials\Constants\PaymentMethodRegistry;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * Class XMLReaderTest
 * @package CredentialsTest\Constants
 * @coversDefaultClass \Credentials\Constants\PaymentMethodRegistry
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class PaymentMethodRegistryTest extends TestCase
{
    /**
     * @return Generator
     */
    public function dataProviderAvailablePaymentMethods()
    {
        foreach ((new PaymentMethodRegistry())->availablePaymentMethods() as $paymentMethod) {
            yield "Available payment method : {$paymentMethod}" => [$paymentMethod];
        }
    }

    /**
     * @group unit
     * @small
     * @dataProvider dataProviderAvailablePaymentMethods
     * @covers ::availablePaymentMethods
     * @param string $paymentMethod
     */
    public function testAvailablePaymentMethods($paymentMethod)
    {
        $paymentMethodRegistry = (new PaymentMethodRegistry())->availablePaymentMethods();
        $this->assertContains($paymentMethod, $paymentMethodRegistry);
    }
}
