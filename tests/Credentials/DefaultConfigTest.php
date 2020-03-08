<?php

namespace CredentialsTest\Reader;

use Credentials\Config\DefaultConfig;
use Credentials\Exception\MissedCredentialsException;
use PHPUnit\Framework\TestCase;

/**
 * Class XMLReaderTest
 * @package CredentialsReaderTest\Reader
 * @coversDefaultClass \Credentials\Config\DefaultConfig
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
        ];
        $defaultConfig = new DefaultConfig($credentials);
        $this->assertEquals($credentials[DefaultConfig::ATTRIBUTE_BASE_URL], $defaultConfig->getBaseUrl());
        $this->assertEquals(
            $credentials[DefaultConfig::ATTRIBUTE_MERCHANT_ACCOUNT_ID],
            $defaultConfig->getMerchantAccountId()
        );
        $this->expectException(MissedCredentialsException::class);
        new DefaultConfig([]);
    }
}
