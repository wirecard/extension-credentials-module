<?php


namespace Credentials\Config;

interface CredentialsContainer
{
    /**
     * @return string[]
     */
    public function toArray();
}
