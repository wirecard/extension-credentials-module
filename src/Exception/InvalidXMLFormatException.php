<?php

namespace Credentials\Exception;

use Exception;

class InvalidXMLFormatException extends Exception
{
    protected $message = "Provided XML not conforms xsd schema rules!";
}
