<?php


namespace WirecardTest\Exception;

use PHPUnit\Framework\TestCase;
use Wirecard\Credentials\Exception\InvalidXMLFormatException;

/**
 * Class InvalidXMLFormatExceptionTest
 * @package CredentialsTest\Exception
 * @coversDefaultClass \Wirecard\Credentials\Exception\InvalidXMLFormatException
 * @since 1.0.0
 */
class InvalidXMLFormatExceptionTest extends TestCase
{
    /**
     * @group unit
     * @small
     * @throws InvalidXMLFormatException
     */
    public function testInvalidXMLFormatException()
    {
        $this->expectException(InvalidXMLFormatException::class);
        $this->expectExceptionMessage("Provided XML not conforms xsd schema rules!");
        throw new InvalidXMLFormatException();
    }
}
