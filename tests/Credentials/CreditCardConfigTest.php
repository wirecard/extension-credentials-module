<?php

namespace CredentialsReaderTest\Reader;

use CredentialsReader\Credentials\CreditCardConfig;
use CredentialsReader\Exception\MissedCredentialsException;
use PHPUnit\Framework\TestCase;

/**
 * Class XMLReaderTest
 * @package CredentialsReaderTest\Reader
 * @coversDefaultClass \CredentialsReader\Credentials\CreditCardConfig
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
            CreditCardConfig::ATTRIBUTE_MERCHANT_ACCOUNT_ID => "123456",
            CreditCardConfig::ATTRIBUTE_BASE_URL => "https://api.wirecard.com",
            CreditCardConfig::ATTRIBUTE_WPP_URL =>  "https://wpp.wirecard.com",
            CreditCardConfig::ATTRIBUTE_3D_SECRET =>  "topSecret",
            CreditCardConfig::ATTRIBUTE_3D_MERCHANT_ACCOUNT_ID =>  "123456",
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
        $this->expectException(MissedCredentialsException::class);
        new CreditCardConfig([]);
    }
}
