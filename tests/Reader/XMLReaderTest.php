<?php

namespace CredentialsReaderTest\Reader;

use Credentials\Exception\InvalidXMLFormatException;
use Credentials\Reader\XMLReader;
use PHPUnit\Framework\TestCase;
use Generator;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class XMLReaderTest
 * @package CredentialsReaderTest\Reader
 * @coversDefaultClass \Credentials\Reader\XMLReader
 * @since 1.0.0
 */
class XMLReaderTest extends TestCase
{
    /**
     * @return string
     */
    private function getSampleXMLRawData()
    {
        return '<?xml version="1.0" encoding="utf-8"?>
                <config>
                    <payment_methods>
                         <creditcard name="Credit Card">
                            <merchant_account_id>merchant_account_id</merchant_account_id>
                            <secret>secret</secret>
                            <base_url>https://api-test.wirecard.com</base_url>
                            <http_user>user</http_user>
                            <http_pass>password</http_pass>
                            <wpp_url>https://wpp-test.wirecard.com</wpp_url>
                            <three_d_merchant_account_id>three_d_merchant_account_id</three_d_merchant_account_id>
                            <three_d_secret>three_d_secret</three_d_secret>
                        </creditcard>
                        <paypal name="PayPal">
                            <merchant_account_id>merchant_account_id</merchant_account_id>
                            <secret>secret</secret>
                            <base_url>https://api-test.wirecard.com</base_url>
                            <http_user>user</http_user>
                            <http_pass>password</http_pass>
                        </paypal>
                    </payment_methods>

                </config>
            ';
    }

    /**
     * @return Generator
     */
    public function plainXMLDataProvider()
    {
        yield "sample_xml_raw_data" => [
            $this->getSampleXMLRawData(),
            [
                "creditcard" => [
                    'merchant_account_id' => 'merchant_account_id',
                    'secret' => 'secret',
                    'base_url' => 'https://api-test.wirecard.com',
                    'http_user' => 'user',
                    'http_pass' => 'password',
                    'wpp_url' => 'https://wpp-test.wirecard.com',
                    'three_d_merchant_account_id' => 'three_d_merchant_account_id',
                    'three_d_secret' => 'three_d_secret',
                ],
                "paypal" => [
                    'merchant_account_id' => 'merchant_account_id',
                    'secret' => 'secret',
                    'base_url' => 'https://api-test.wirecard.com',
                    'http_user' => 'user',
                    'http_pass' => 'password',
                ]
            ]];
    }

    /**
     * @group unit
     * @small
     * @covers ::toArray()
     * @dataProvider plainXMLDataProvider
     * @param string $data
     * @param array $expectedResult
     * @throws InvalidXMLFormatException
     */
    public function testToArray($data, $expectedResult)
    {
        /** @var XMLReader | PHPUnit_Framework_MockObject_MockObject $reader */
        $reader = new XMLReader($data);
        $this->assertEquals($expectedResult, $reader->toArray());
    }

    /**
     * @group unit
     * @small
     * @covers ::validate
     * @throws InvalidXMLFormatException
     */
    public function testValidate()
    {
        $testXMLString = $this->getSampleXMLRawData();
        new XMLReader($testXMLString);
        new XMLReader('<?xml version="1.0" encoding="utf-8"?><config><payment_methods></payment_methods></config>');
        $this->expectException(InvalidXMLFormatException::class);
        new XMLReader('<?xml version="1.0" encoding="utf-8"?><config><invalid_payment_type>
                            </invalid_payment_type></config>');
        $this->expectException(InvalidXMLFormatException::class);
        new XMLReader('<?xml version="1.0" encoding="utf-8"?><configs></configs>');
    }
}