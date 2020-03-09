<?php

namespace Credentials\Config;

/**
 * Interface CredentialsCreditCardConfigInterface
 * @package Credentials\Config
 */
interface CredentialsCreditCardConfigInterface extends CredentialsConfigInterface
{
    /**
     * @return string
     */
    public function getWppUrl();

    /**
     * @return string
     */
    public function getThreeDSecret();

    /**
     * @return string
     */
    public function getThreeDMerchantAccountId();
}
