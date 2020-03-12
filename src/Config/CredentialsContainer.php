<?php


namespace Wirecard\Credentials\Config;

interface CredentialsContainer
{
    /**
     * @return string[]
     */
    public function toArray();
}
