<?php


namespace CredentialsTest;

use Credentials\Exception\InvalidPaymentMethodException;
use Credentials\PaymentMethod;
use Credentials\PaymentMethodRegistry;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * Class PaymentMethodTest
 * @package CredentialsTest
 * @coversDefaultClass \Credentials\PaymentMethod
 * @SuppressWarnings(PHPMD.LongVariable)
 * @since 1.0.0
 */
class PaymentMethodTest extends TestCase
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
        foreach ((new PaymentMethodRegistry())->availablePaymentMethods() as $pm) {
            yield $pm => [$pm];
        }
    }

    /**
     * @group unit
     * @small
     * @dataProvider dataProviderAvailablePaymentMethods
     * @covers ::getValue
     * @param string $value
     * @throws InvalidPaymentMethodException
     */
    public function testConstructor($value)
    {
        $paymentMethod = new PaymentMethod($value, $this->registry);
        $this->assertInstanceOf(PaymentMethod::class, $paymentMethod);
        $this->assertEquals($value, $paymentMethod->getValue());
        $this->assertEquals($value, (string)$paymentMethod);
    }

    /**
     * @return Generator
     */
    public function dataProviderInvalidTypeValues()
    {
        yield "string" => ["fooBarFoo"];
        yield "null" => [null];
        yield "null_string" => ["null"];
        yield "empty_string" => [""];
        yield "negative_number" => [-123];
        yield "positive_number" => [123];
        yield "bool_false" => [false];
        yield "bool_true" => [true];
    }

    /**
     * @group unit
     * @small
     * @dataProvider dataProviderInvalidTypeValues
     * @param mixed $invalidValue
     * @throws InvalidPaymentMethodException
     */
    public function testConstructorException($invalidValue)
    {
        $this->expectException(InvalidPaymentMethodException::class);
        new PaymentMethod($invalidValue, $this->registry);
    }

    /**
     * @group unit
     * @small
     * @covers ::equalsTo
     * @throws InvalidPaymentMethodException
     */
    public function testEqualsTo()
    {
        $paymentMethod = new PaymentMethod(PaymentMethodRegistry::TYPE_IDEAL, $this->registry);
        $this->assertTrue($paymentMethod->equalsTo(PaymentMethodRegistry::TYPE_IDEAL));
        $this->assertFalse($paymentMethod->equalsTo(PaymentMethodRegistry::TYPE_SOFORTBANKING));
    }
}
