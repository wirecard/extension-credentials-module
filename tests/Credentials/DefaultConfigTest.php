<?php

namespace CredentialsTest\Reader;

use Credentials\Config\CredentialsConfigInterface;
use Credentials\Config\DefaultConfig;
use Credentials\Exception\MissedCredentialsException;
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
     * @throws MissedCredentialsException
     */
    public function testConstructor()
    {
        $credentials = [
            DefaultConfig::ATTRIBUTE_MERCHANT_ACCOUNT_ID => "123456",
            DefaultConfig::ATTRIBUTE_BASE_URL => "https://base.wirecard.com",
            DefaultConfig::ATTRIBUTE_SECRET => "secret",
            DefaultConfig::ATTRIBUTE_HTTP_USER => "http_user",
            DefaultConfig::ATTRIBUTE_HTTP_PASSWORD => "http_password",
        ];
        $defaultConfig = new DefaultConfig($credentials);
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
        new DefaultConfig([]);
    }
}
