<?php

namespace CredentialsTest\Reader;

use Credentials\Config\CredentialsConfigInterface;
use Credentials\Config\CredentialsCreditCardConfigInterface;
use Credentials\Config\CreditCardConfig;
use Credentials\Config\DefaultConfig;
use Credentials\Exception\MissedCredentialsException;
use PHPUnit\Framework\TestCase;

/**
 * Class XMLReaderTest
 * @package CredentialsTest\Reader
 * @coversDefaultClass \Credentials\Config\CreditCardConfig
 */
class CreditCardConfigTest extends TestCase
{
    /**
     * @group unit
     * @small
     * @throws MissedCredentialsException
     */
    public function testConstructor()
    {
        $credentials = [
            DefaultConfig::ATTRIBUTE_MERCHANT_ACCOUNT_ID => "123456",
            DefaultConfig::ATTRIBUTE_BASE_URL => "https://api.wirecard.com",
            DefaultConfig::ATTRIBUTE_SECRET => "secret",
            DefaultConfig::ATTRIBUTE_HTTP_USER => "http_user",
            DefaultConfig::ATTRIBUTE_HTTP_PASSWORD => "http_password",

            CreditCardConfig::ATTRIBUTE_WPP_URL => "https://wpp.wirecard.com",
            CreditCardConfig::ATTRIBUTE_3D_SECRET => "topSecret",
            CreditCardConfig::ATTRIBUTE_3D_MERCHANT_ACCOUNT_ID => "123456",
        ];
        $creditCardConfig = new CreditCardConfig($credentials);
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
        $this->assertInstanceOf(CredentialsCreditCardConfigInterface::class, $creditCardConfig);
        $this->assertInstanceOf(CredentialsConfigInterface::class, $creditCardConfig);
        $this->expectException(MissedCredentialsException::class);
        new CreditCardConfig([]);
    }
}
