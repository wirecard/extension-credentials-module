<?php

namespace CredentialsReaderTest\Credentials;

use CredentialsReader\Constants\PaymentMethod;
use CredentialsReader\Credentials\ConfigFactory;
use CredentialsReader\Credentials\CreditCardConfig;
use CredentialsReader\Credentials\DefaultConfig;
use CredentialsReader\Exception\MissedCredentialsException;
use CredentialsReader\Exception\InvalidPaymentMethodException;
use PHPUnit\Framework\TestCase;

/**
 * Class XMLReaderTest
 * @package CredentialsReaderTest\Reader
 * @coversDefaultClass \CredentialsReader\Credentials\ConfigFactory
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
     * @group unit
     * @small
     * @covers ::createConfig
     * @throws InvalidPaymentMethodException
     * @throws MissedCredentialsException
     */
    public function testCreateConfig()
    {
        $factory = new ConfigFactory();
        $credentials = [
            CreditCardConfig::ATTRIBUTE_MERCHANT_ACCOUNT_ID => "123456",
            CreditCardConfig::ATTRIBUTE_BASE_URL => "https://api.wirecard.com",
            CreditCardConfig::ATTRIBUTE_WPP_URL => "https://wpp.wirecard.com",
            CreditCardConfig::ATTRIBUTE_3D_SECRET => "topSecret",
            CreditCardConfig::ATTRIBUTE_3D_MERCHANT_ACCOUNT_ID => "123456",
        ];
        $creditCardConfig = $factory->createConfig(
            PaymentMethod::TYPE_CREDIT_CARD,
            $credentials
        );
        $this->assertInstanceOf(CreditCardConfig::class, $creditCardConfig);

        $credentials = [
            CreditCardConfig::ATTRIBUTE_MERCHANT_ACCOUNT_ID => "123456",
            CreditCardConfig::ATTRIBUTE_BASE_URL => "https://api.wirecard.com",
        ];

        $creditCardConfig = $factory->createConfig(
            PaymentMethod::TYPE_PAYPAL,
            $credentials
        );

        $this->assertInstanceOf(DefaultConfig::class, $creditCardConfig);
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
        $creditCardCredentials = [
            CreditCardConfig::ATTRIBUTE_MERCHANT_ACCOUNT_ID => "123456",
            CreditCardConfig::ATTRIBUTE_BASE_URL => "https://api.wirecard.com",
            CreditCardConfig::ATTRIBUTE_WPP_URL => "https://wpp.wirecard.com",
            CreditCardConfig::ATTRIBUTE_3D_SECRET => "topSecret",
            CreditCardConfig::ATTRIBUTE_3D_MERCHANT_ACCOUNT_ID => "123456",
        ];

        $paypalCredentials = [
            CreditCardConfig::ATTRIBUTE_MERCHANT_ACCOUNT_ID => "123456",
            CreditCardConfig::ATTRIBUTE_BASE_URL => "https://api.wirecard.com",
        ];

        $result = $factory->createConfigList([
            PaymentMethod::TYPE_CREDIT_CARD => $creditCardCredentials,
            PaymentMethod::TYPE_PAYPAL => $paypalCredentials,
        ]);

        $this->assertArrayHasKey(PaymentMethod::TYPE_CREDIT_CARD, $result);
        $this->assertArrayHasKey(PaymentMethod::TYPE_PAYPAL, $result);
    }
}
