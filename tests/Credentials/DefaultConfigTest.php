<?php

namespace CredentialsTest\Reader;

use Credentials\Config\CredentialsConfigInterface;
use Credentials\Config\DefaultConfig;
use Credentials\Exception\InvalidPaymentMethodException;
use Credentials\Exception\MissedCredentialsException;
use Credentials\PaymentMethodRegistry;
use PHPUnit\Framework\TestCase;

/**
 * Class DefaultConfigTest
 * @package CredentialsTest\Reader
 * @coversDefaultClass \Credentials\Config\DefaultConfig
 * @since 1.0.0
 */
class DefaultConfigTest extends TestCase
{
    /**
     * @group unit
     * @small
     * @covers ::getPaymentMethod
     * @covers ::getBaseUrl
     * @covers ::getHttpUser
     * @covers ::getHttpPassword
     * @covers ::getMerchantAccountId
     * @covers ::getSecret
     * @throws MissedCredentialsException
     * @throws InvalidPaymentMethodException
     */
    public function testConstructor()
    {
        $paymentMethodRegistry = new PaymentMethodRegistry();
        $credentials = [
            DefaultConfig::ATTRIBUTE_MERCHANT_ACCOUNT_ID => "123456",
            DefaultConfig::ATTRIBUTE_BASE_URL => "https://base.wirecard.com",
            DefaultConfig::ATTRIBUTE_SECRET => "secret",
            DefaultConfig::ATTRIBUTE_HTTP_USER => "http_user",
            DefaultConfig::ATTRIBUTE_HTTP_PASSWORD => "http_password",
        ];
        $pm = $paymentMethodRegistry->getPaymentMethod(
            PaymentMethodRegistry::TYPE_PAYPAL
        );
        $defaultConfig = new DefaultConfig($pm, $credentials);
        $this->assertEquals($pm, $defaultConfig->getPaymentMethod());
        $this->assertEquals(
            PaymentMethodRegistry::TYPE_PAYPAL,
            $defaultConfig->getPaymentMethod()->getValue()
        );
        $this->assertEquals($credentials[DefaultConfig::ATTRIBUTE_BASE_URL], $defaultConfig->getBaseUrl());
        $this->assertEquals(
            $credentials[DefaultConfig::ATTRIBUTE_MERCHANT_ACCOUNT_ID],
            $defaultConfig->getMerchantAccountId()
        );
        $this->assertEquals(
            $credentials[DefaultConfig::ATTRIBUTE_SECRET],
            $defaultConfig->getSecret()
        );
        $this->assertEquals(
            $credentials[DefaultConfig::ATTRIBUTE_HTTP_USER],
            $defaultConfig->getHttpUser()
        );
        $this->assertEquals(
            $credentials[DefaultConfig::ATTRIBUTE_HTTP_PASSWORD],
            $defaultConfig->getHttpPassword()
        );
        $this->assertInstanceOf(DefaultConfig::class, $defaultConfig);
        $this->assertInstanceOf(CredentialsConfigInterface::class, $defaultConfig);

        $this->expectException(MissedCredentialsException::class);
        new DefaultConfig($paymentMethodRegistry->getPaymentMethod(
            PaymentMethodRegistry::TYPE_PAYPAL
        ), []);
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
        $paymentMethodRegistry = new PaymentMethodRegistry();
        $credentials = [
            DefaultConfig::ATTRIBUTE_MERCHANT_ACCOUNT_ID => "123456",
            DefaultConfig::ATTRIBUTE_BASE_URL => "https://base.wirecard.com",
            DefaultConfig::ATTRIBUTE_SECRET => "secret",
            DefaultConfig::ATTRIBUTE_HTTP_USER => "http_user",
            DefaultConfig::ATTRIBUTE_HTTP_PASSWORD => "http_password",
        ];
        $pm = $paymentMethodRegistry->getPaymentMethod(
            PaymentMethodRegistry::TYPE_PAYPAL
        );
        $defaultConfig = new DefaultConfig($pm, $credentials);
        $this->assertEquals($credentials, $defaultConfig->toArray());
    }
}
