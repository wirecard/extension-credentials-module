<?php

namespace CredentialsTest\Reader;

use Credentials\Config\CredentialsConfigInterface;
use Credentials\Config\CredentialsCreditCardConfig;
use Credentials\Config\CreditCardConfig;
use Credentials\Config\DefaultConfig;
use Credentials\Exception\InvalidPaymentMethodException;
use Credentials\Exception\MissedCredentialsException;
use Credentials\PaymentMethod;
use Credentials\PaymentMethodRegistry;
use PHPUnit\Framework\TestCase;

/**
 * Class CreditCardConfigTest
 * @package CredentialsTest\Reader
 * @coversDefaultClass \Credentials\Config\CreditCardConfig
 * @since 1.0.0
 */
class CreditCardConfigTest extends TestCase
{
    /**
     * @return array
     */
    private function getDefaultCredentials()
    {
        return [
            DefaultConfig::ATTRIBUTE_MERCHANT_ACCOUNT_ID => "123456",
            DefaultConfig::ATTRIBUTE_BASE_URL => "https://api.wirecard.com",
            DefaultConfig::ATTRIBUTE_SECRET => "secret",
            DefaultConfig::ATTRIBUTE_HTTP_USER => "http_user",
            DefaultConfig::ATTRIBUTE_HTTP_PASSWORD => "http_password",

            CreditCardConfig::ATTRIBUTE_WPP_URL => "https://wpp.wirecard.com",
            CreditCardConfig::ATTRIBUTE_3D_SECRET => "topSecret",
            CreditCardConfig::ATTRIBUTE_3D_MERCHANT_ACCOUNT_ID => "123456",
        ];
    }

    /**
     * @group unit
     * @small
     * @covers ::getThreeDSecret
     * @covers ::getThreeDMerchantAccountId
     * @covers ::getWppUrl
     * @throws MissedCredentialsException
     * @throws InvalidPaymentMethodException
     */
    public function testConstructor()
    {
        $pMethodRegistry = new PaymentMethodRegistry();
        $credentials = $this->getDefaultCredentials();
        $paymentMethod = new PaymentMethod(
            PaymentMethodRegistry::TYPE_CREDIT_CARD,
            $pMethodRegistry
        );
        $creditCardConfig = new CreditCardConfig($paymentMethod, $credentials);
        $this->assertEquals($credentials[CreditCardConfig::ATTRIBUTE_BASE_URL], $creditCardConfig->getBaseUrl());
        $this->assertEquals(
            $credentials[CreditCardConfig::ATTRIBUTE_MERCHANT_ACCOUNT_ID],
            $creditCardConfig->getMerchantAccountId()
        );
        $this->assertEquals(
            $credentials[CreditCardConfig::ATTRIBUTE_WPP_URL],
            $creditCardConfig->getWppUrl()
        );
        $this->assertEquals(
            $credentials[CreditCardConfig::ATTRIBUTE_3D_SECRET],
            $creditCardConfig->getThreeDSecret()
        );
        $this->assertEquals(
            $credentials[CreditCardConfig::ATTRIBUTE_3D_MERCHANT_ACCOUNT_ID],
            $creditCardConfig->getThreeDMerchantAccountId()
        );
        $this->assertInstanceOf(CreditCardConfig::class, $creditCardConfig);
        $this->assertInstanceOf(CredentialsCreditCardConfig::class, $creditCardConfig);
        $this->assertInstanceOf(CredentialsConfigInterface::class, $creditCardConfig);
        $this->expectException(MissedCredentialsException::class);
        new CreditCardConfig($paymentMethod, []);
    }

    /**
     * @group unit
     * @small
     * @covers ::toArray
     * @throws InvalidPaymentMethodException
     * @throws MissedCredentialsException
     */
    public function testToArray()
    {
        $pMethodRegistry = new PaymentMethodRegistry();
        $credentials = $this->getDefaultCredentials();
        $paymentMethod = $pMethodRegistry->getPaymentMethod(
            PaymentMethodRegistry::TYPE_CREDIT_CARD
        );
        $creditCardConfig = new CreditCardConfig($paymentMethod, $credentials);
        $this->assertEquals($credentials, $creditCardConfig->toArray());
    }
}
