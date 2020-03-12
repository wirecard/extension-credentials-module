<?php


namespace WirecardTest\Exception;

use PHPUnit\Framework\TestCase;
use Wirecard\Credentials\Exception\MissedCredentialsException;

/**
 * Class MissedCredentialsExceptionTest
 * @package CredentialsTest\Constants
 * @coversDefaultClass \Wirecard\Credentials\Exception\MissedCredentialsException
 * @since 1.0.0
 */
class MissedCredentialsExceptionTest extends TestCase
{
    /**
     * @group unit
     * @small
     * @throws MissedCredentialsException
     */
    public function testMissedCredentialsException()
    {
        $this->expectException(MissedCredentialsException::class);
        $this->expectExceptionMessage("Following fields: [X, Y, Z] are required!");
        throw new MissedCredentialsException(['X', 'Y', 'Z']);
    }
}
