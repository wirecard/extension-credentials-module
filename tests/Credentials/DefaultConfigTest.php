<?php

namespace CredentialsReaderTest\Reader;

use CredentialsReader\Credentials\DefaultConfig;
use CredentialsReader\Exception\MissedCredentialsException;
use PHPUnit\Framework\TestCase;

/**
 * Class XMLReaderTest
 * @package CredentialsReaderTest\Reader
 * @coversDefaultClass \CredentialsReader\Credentials\DefaultConfig
 */
class DefaultConfigTest extends TestCase
{
    /**
     * @group unit
     * @small
     * @throws \CredentialsReader\Exception\MissedCredentialsException
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
        $defaultConfig = new DefaultConfig([]);
    }
}