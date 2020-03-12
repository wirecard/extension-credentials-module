<?php

namespace Wirecard\Credentials\Exception;

use Exception;

/**
 * Class InvalidXMLFormatException
 * @package Credentials\Exception
 * @since 1.0.0
 */
class InvalidXMLFormatException extends Exception
{
    /**
     * @var string
     */
    protected $message = "Provided XML not conforms xsd schema rules!";
}
