<?php

namespace CredentialsReaderTest\Reader;

use CredentialsReader\Reader\XMLReader;
use PHPUnit\Framework\TestCase;

class XMLReaderTest extends TestCase
{
    /**
     * @return \Generator
     */
    public function plainXMLDataProvider()
    {
        yield "test_empty_entry" => ["", []];

        yield "test_null" => [null, []];

        yield "test_false" => [false, []];

        yield "test_xml_sample_one_node" => [
            "<?xml version=\"1.0\" encoding=\"utf-8\"?>
                <config xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
                xsi:schemaLocation=\"config.xsd\">
                    <creditcard>
                        <merchant_account_id>a1-d2-c3-d4</merchant_account_id>
                        <base_url>https://api.wirecard.com</base_url>
                    </creditcard>
                </config>
            ",

            [
                "creditcard" => [
                    'merchant_account_id' => 'a1-d2-c3-d4',
                    'base_url' => 'https://api.wirecard.com'
                ]
            ]];
        yield "test_xml_sample_two_node" => [
            "<?xml version=\"1.0\" encoding=\"utf-8\"?>
                <config xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
                xsi:schemaLocation=\"config.xsd\">
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
            ",

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
     */
    public function testConstructor($data, $expectedResult)
    {
        $reader = new XMLReader($data);
        $this->assertTrue(is_array($reader->getCredentials()));
        $this->assertEquals($expectedResult, $reader->getCredentials());
    }
}
