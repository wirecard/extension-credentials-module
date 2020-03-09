<?php

namespace Credentials\Config;

/**
 * Interface CredentialsCreditCardConfigInterface
 * @package Credentials\Config
 * @since 1.0.0
 */
interface CredentialsCreditCardConfigInterface extends CredentialsConfigInterface
{
    /**
     * @return string
     * @since 1.0.0
     */
    public function getWppUrl();

    /**
     * @return string
     * @since 1.0.0
     */
    public function getThreeDSecret();

    /**
     * @return string
     * @since 1.0.0
     */
    public function getThreeDMerchantAccountId();
}
