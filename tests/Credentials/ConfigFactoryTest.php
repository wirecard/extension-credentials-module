<?php

namespace CredentialsTest\Credentials;

use Credentials\Constants\PaymentMethod;
use Credentials\Config\ConfigFactory;
use Credentials\Config\CreditCardConfig;
use Credentials\Config\DefaultConfig;
use Credentials\Exception\MissedCredentialsException;
use Credentials\Exception\InvalidPaymentMethodException;
use PHPUnit\Framework\TestCase;
use Generator;

/**
 * Class XMLReaderTest
 * @package CredentialsReaderTest\Reader
 * @coversDefaultClass \Credentials\Config\ConfigFactory
 */
class CreditCardConfigTest extends TestCase
{
    /**
     * @group unit
     * @small
     * @covers ::createConfig
     * @throws InvalidPaymentMethodException
     * @throws MissedCredentialsException
     */
    public function testCreateConfigException()
    {
        $factory = new ConfigFactory();

        $this->expectException(MissedCredentialsException::class);
        $factory->createConfig(PaymentMethod::TYPE_CREDIT_CARD, []);
        $this->expectException(InvalidPaymentMethodException::class);
        $factory->createConfig("InvalidType", []);
    }


    /**
     * @return array
     */
    public function getDefaultConfigCredentials()
    {
        return [
            CreditCardConfig::ATTRIBUTE_MERCHANT_ACCOUNT_ID => "123456",
            CreditCardConfig::ATTRIBUTE_BASE_URL => "https://api.wirecard.com",
        ];
    }

    /**
     * @return array
     */
    public function getCreditCardConfigCredentials()
    {
        return [
            CreditCardConfig::ATTRIBUTE_MERCHANT_ACCOUNT_ID => "123456",
            CreditCardConfig::ATTRIBUTE_BASE_URL => "https://api.wirecard.com",
            CreditCardConfig::ATTRIBUTE_WPP_URL => "https://wpp.wirecard.com",
            CreditCardConfig::ATTRIBUTE_3D_SECRET => "topSecret",
            CreditCardConfig::ATTRIBUTE_3D_MERCHANT_ACCOUNT_ID => "123456",
        ];
    }

    /**
     * @return Generator
     */
    public function createConfigDataProvider()
    {

        yield "create credit card config" => [
            PaymentMethod::TYPE_CREDIT_CARD,
            $this->getCreditCardConfigCredentials(),
            CreditCardConfig::class
        ];
        yield "create default config" => [
            PaymentMethod::TYPE_PAYPAL,
            $this->getDefaultConfigCredentials(),
            DefaultConfig::class
        ];
    }

    /**
     * @group unit
     * @small
     * @covers ::createConfig
     * @dataProvider createConfigDataProvider
     * @param string $type
     * @param array $credentials
     * @param string $configClass
     * @throws InvalidPaymentMethodException
     * @throws MissedCredentialsException
     */
    public function testCreateConfig($type, $credentials, $configClass)
    {
        $factory = new ConfigFactory();
        $config = $factory->createConfig(
            $type,
            $credentials
        );
        $this->assertInstanceOf($configClass, $config);
    }

    /**
     * @group unit
     * @small
     * @covers ::createConfigList
     * @throws InvalidPaymentMethodException
     * @throws MissedCredentialsException
     */
    public function testCreateConfigList()
    {
        $factory = new ConfigFactory();

        $result = $factory->createConfigList([
            PaymentMethod::TYPE_CREDIT_CARD => $this->getCreditCardConfigCredentials(),
            PaymentMethod::TYPE_PAYPAL => $this->getDefaultConfigCredentials(),
        ]);

        $this->assertTrue(is_array($result));
        $this->assertNotEmpty(is_array($result));
        $this->assertCount(2, $result);
        $this->assertArrayHasKey(PaymentMethod::TYPE_CREDIT_CARD, $result);
        $this->assertArrayHasKey(PaymentMethod::TYPE_PAYPAL, $result);
    }
}
