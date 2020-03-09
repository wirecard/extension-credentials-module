<?php

namespace CredentialsTest;

use Generator;
use Credentials\Exception\InvalidPaymentMethodException;
use Credentials\PaymentMethod;
use Credentials\PaymentMethodRegistry;
use PHPUnit\Framework\TestCase;

/**
 * Class XMLReaderTest
 * @package CredentialsTest
 * @coversDefaultClass \Credentials\PaymentMethodRegistry
 * @SuppressWarnings(PHPMD.LongVariable)
 * @since 1.0.0
 */
class PaymentMethodRegistryTest extends TestCase
{
    /**
     * @var PaymentMethodRegistry
     */
    private $registry;

    protected function setUp()
    {
        $this->registry = new PaymentMethodRegistry();
    }

    /**
     * @return Generator
     * @throws InvalidPaymentMethodException
     */
    public function dataProviderAvailablePaymentMethods()
    {
        $registry = new PaymentMethodRegistry();
        foreach ($registry->availablePaymentMethods() as $paymentMethod) {
            yield $paymentMethod => [$paymentMethod, new PaymentMethod($paymentMethod, $registry)];
        }
    }

    /**
     * @group unit
     * @small
     * @covers ::availablePaymentMethods
     * @dataProvider dataProviderAvailablePaymentMethods
     * @param string $paymentMethod
     * @param PaymentMethod $expectedObject
     * @throws InvalidPaymentMethodException
     */
    public function testConstructor($paymentMethod, $expectedObject)
    {
        $this->assertTrue($this->registry->hasPaymentMethod($paymentMethod));
        $this->assertEquals($expectedObject, $this->registry->getPaymentMethod($paymentMethod));
    }

    /**
     * @group unit
     * @small
     * @covers ::getPaymentMethod
     * @throws InvalidPaymentMethodException
     */
    public function testGetPaymentMethod()
    {
        $paymentMethod = $this->registry->getPaymentMethod(PaymentMethodRegistry::TYPE_EPS);
        $this->assertEquals(PaymentMethodRegistry::TYPE_EPS, $paymentMethod->getValue());
        $this->assertInstanceOf(PaymentMethod::class, $paymentMethod);
        $this->expectException(InvalidPaymentMethodException::class);
        $this->registry->getPaymentMethod("InvalidType");
    }
}
