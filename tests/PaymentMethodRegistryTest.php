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
        foreach ($registry->availablePaymentMethods() as $pm) {
            yield $pm => [$pm, new PaymentMethod($pm, $registry)];
        }
    }

    /**
     * @group unit
     * @small
     * @covers ::availablePaymentMethods
     * @dataProvider dataProviderAvailablePaymentMethods
     * @param string $pm
     * @param PaymentMethod $expectedObject
     * @throws InvalidPaymentMethodException
     */
    public function testConstructor($pm, $expectedObject)
    {
        $this->assertTrue($this->registry->hasPaymentMethod($pm));
        $this->assertEquals($expectedObject, $this->registry->getPaymentMethod($pm));
    }

    /**
     * @group unit
     * @small
     * @covers ::getPaymentMethod
     * @throws InvalidPaymentMethodException
     */
    public function testGetPaymentMethod()
    {
        $pm = $this->registry->getPaymentMethod(PaymentMethodRegistry::TYPE_EPS);
        $this->assertEquals(PaymentMethodRegistry::TYPE_EPS, $pm->getValue());
        $this->assertInstanceOf(PaymentMethod::class, $pm);
        $this->expectException(InvalidPaymentMethodException::class);
        $this->registry->getPaymentMethod("InvalidType");
    }
}
