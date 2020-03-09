<?php

namespace CredentialsReaderTest\Reader;

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
     * @return Generator
     */
    public function plainXMLDataProvider()
    {
        yield "test_xml_sample_one_node" => [
            '<?xml version="1.0" encoding="utf-8"?>
                <config>
                    <creditcard>
                        <merchant_account_id>a1-d2-c3-d4</merchant_account_id>
                        <base_url>https://api.wirecard.com</base_url>
                    </creditcard>
                </config>
            ',

            [
                "creditcard" => [
                    'merchant_account_id' => 'a1-d2-c3-d4',
                    'base_url' => 'https://api.wirecard.com'
                ]
            ]];
        yield "test_xml_sample_two_node" => [
            '<?xml version="1.0" encoding="utf-8"?>
                <config>
                    <creditcard>
                        <merchant_account_id>merchant_account_id</merchant_account_id>
                        <secret>secret</secret>
                        <base_url>https://api-test.wirecard.com</base_url>
                        <http_user>user</http_user>
                        <http_pass>password</http_pass>
                        <wpp_url>https://wpp-test.wirecard.com</wpp_url>
                        <three_d_merchant_account_id>three_d_merchant_account_id</three_d_merchant_account_id>
                        <three_d_secret>three_d_secret</three_d_secret>
                    </creditcard>
                    <paypal>
                        <merchant_account_id>merchant_account_id</merchant_account_id>
                        <secret>secret</secret>
                        <base_url>https://api-test.wirecard.com</base_url>
                        <http_user>user</http_user>
                        <http_pass>password</http_pass>
                    </paypal>
                </config>
            ',

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
     * @param string $data
     * @param array $expectedResult
     * @dataProvider plainXMLDataProvider
     * @covers ::getCredentials()
     */
    public function testCredentials($data, $expectedResult)
    {
        /** @var XMLReader | PHPUnit_Framework_MockObject_MockObject $reader */
        $reader = $this->getMockBuilder(XMLReader::class)
            ->setMethods(['getRawXML'])->disableOriginalConstructor()->getMock();
        $reader->expects($this->any())->method('getRawXML')->willReturn($data);
        $this->assertEquals($expectedResult, $reader->toArray());
    }

    public function testValidate()
    {
        $testXMLString = '<?xml version="1.0" encoding="utf-8"?>
                <config 
                >
                    <creditcard>
                        <merchant_account_id>merchant_account_id</merchant_account_id>
                        <secret>secret</secret>
                        <base_url>https://api-test.wirecard.com</base_url>
                        <http_user>user</http_user>
                        <http_pass>password</http_pass>
                        <wpp_url>https://wpp-test.wirecard.com</wpp_url>
                        <three_d_merchant_account_id>three_d_merchant_account_id</three_d_merchant_account_id>
                        <three_d_secret>three_d_secret</three_d_secret>
                    </creditcard>
                    <paypal>
                        <merchant_account_id>merchant_account_id</merchant_account_id>
                        <secret>secret</secret>
                        <base_url>https://api-test.wirecard.com</base_url>
                        <http_user>user</http_user>
                        <http_pass>password</http_pass>
                    </paypal>
                </config>
            ';
        /** @var XMLReader | PHPUnit_Framework_MockObject_MockObject $reader */
        $reader = $this->getMockBuilder(XMLReader::class)
            ->setMethods(['getRawXML'])->disableOriginalConstructor()->getMock();
        $reader->expects($this->any())->method('getRawXML')->willReturn($testXMLString);
        $this->assertEquals(true, $reader->validate());
    }
}
