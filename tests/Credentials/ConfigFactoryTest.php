<?php

namespace CredentialsTest\Credentials;

use Credentials\Config\CredentialsConfigInterface;
use Credentials\Config\CredentialsCreditCardConfigInterface;
use Credentials\Constants\PaymentMethodRegistry;
use Credentials\Config\ConfigFactory;
use Credentials\Config\CreditCardConfig;
use Credentials\Config\DefaultConfig;
use Credentials\Exception\MissedCredentialsException;
use Credentials\Exception\InvalidPaymentMethodException;
use PHPUnit\Framework\TestCase;
use Generator;

/**
 * Class XMLReaderTest
 * @package CredentialsTest\Reader
 * @coversDefaultClass \Credentials\Config\ConfigFactory
 * @SuppressWarnings(PHPMD.LongVariable)
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
        $factory->createConfig(PaymentMethodRegistry::TYPE_CREDIT_CARD, []);
        $this->expectException(InvalidPaymentMethodException::class);
        $factory->createConfig("InvalidType", []);
    }


    /**
     * @return array
     */
    public function getDefaultConfigCredentials()
    {
        return [
            DefaultConfig::ATTRIBUTE_MERCHANT_ACCOUNT_ID => "123456",
            DefaultConfig::ATTRIBUTE_BASE_URL => "https://base.wirecard.com",
            DefaultConfig::ATTRIBUTE_SECRET => "secret",
            DefaultConfig::ATTRIBUTE_HTTP_USER => "http_user",
            DefaultConfig::ATTRIBUTE_HTTP_PASSWORD => "http_password",
        ];
    }

    /**
     * @return array
     */
    public function getCreditCardConfigCredentials()
    {
        $creditCardCredentials = [
            CreditCardConfig::ATTRIBUTE_WPP_URL => "https://wpp.wirecard.com",
            CreditCardConfig::ATTRIBUTE_3D_SECRET => "topSecret",
            CreditCardConfig::ATTRIBUTE_3D_MERCHANT_ACCOUNT_ID => "123456",
        ];

        return array_merge($this->getDefaultConfigCredentials(), $creditCardCredentials);
    }

    /**
     * @return Generator
     */
    public function createConfigDataProvider()
    {
        yield "create credit card config" => [
            PaymentMethodRegistry::TYPE_CREDIT_CARD,
            $this->getCreditCardConfigCredentials(),
            CreditCardConfig::class,
            CredentialsCreditCardConfigInterface::class
        ];

        $availablePaymentMethodList = (new PaymentMethodRegistry())->availablePaymentMethods();
        array_shift($availablePaymentMethodList);
        foreach ($availablePaymentMethodList as $paymentMethod) {
            yield "create default config {$paymentMethod}" => [
                PaymentMethodRegistry::TYPE_MASTERPASS,
                $this->getDefaultConfigCredentials(),
                DefaultConfig::class,
                CredentialsConfigInterface::class
            ];
        }
    }

    /**
     * @group unit
     * @small
     * @covers ::createConfig
     * @dataProvider createConfigDataProvider
     * @param string $type
     * @param array $credentials
     * @param string $configClass
     * @param string $configInterface
     * @throws InvalidPaymentMethodException
     * @throws MissedCredentialsException
     */
    public function testCreateConfig($type, $credentials, $configClass, $configInterface)
    {
        $factory = new ConfigFactory();
        $config = $factory->createConfig(
            $type,
            $credentials
        );
        $this->assertInstanceOf($configClass, $config);
        $this->assertInstanceOf($configInterface, $config);
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
            PaymentMethodRegistry::TYPE_CREDIT_CARD => $this->getCreditCardConfigCredentials(),
            PaymentMethodRegistry::TYPE_PAYPAL => $this->getDefaultConfigCredentials(),
        ]);

        $this->assertTrue(is_array($result));
        $this->assertNotEmpty(is_array($result));
        $this->assertCount(2, $result);
        $this->assertArrayHasKey(PaymentMethodRegistry::TYPE_CREDIT_CARD, $result);
        $this->assertArrayHasKey(PaymentMethodRegistry::TYPE_PAYPAL, $result);
    }
}
