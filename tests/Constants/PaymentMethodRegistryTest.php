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
        yield [PaymentMethodRegistry::TYPE_CREDIT_CARD];
        yield [PaymentMethodRegistry::TYPE_PAYPAL];
        yield [PaymentMethodRegistry::TYPE_SOFORTBANKING];
        yield [PaymentMethodRegistry::TYPE_ALIPAY_XBORDER];
        yield [PaymentMethodRegistry::TYPE_IDEAL];
        yield [PaymentMethodRegistry::TYPE_WIRETRANSFER];
        yield [PaymentMethodRegistry::TYPE_RATEPAY];
        yield [PaymentMethodRegistry::TYPE_EPS];
        yield [PaymentMethodRegistry::TYPE_GIROPAY];
        yield [PaymentMethodRegistry::TYPE_ZAPP];
        yield [PaymentMethodRegistry::TYPE_SEPACREDIT];
        yield [PaymentMethodRegistry::TYPE_SEPA_DIRECT_DEBIT];
        yield [PaymentMethodRegistry::TYPE_MASTERPASS];
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
