<?php


namespace CredentialsTest\Exception;

use PHPUnit\Framework\TestCase;
use Credentials\Exception\MissedCredentialsException;

/**
 * Class MissedCredentialsExceptionTest
 * @package CredentialsTest\Constants
 * @coversDefaultClass \Credentials\Exception\MissedCredentialsException
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
