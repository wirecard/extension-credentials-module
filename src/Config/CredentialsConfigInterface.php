<?php

namespace Wirecard\Credentials\Config;

/**
 * Interface CredentialsConfigInterface
 * @package Credentials\Config
 * @since 1.0.0
 */
interface CredentialsConfigInterface extends CredentialsContainer
{
    /**
     * @return string
     * @since 1.0.0
     */
    public function getMerchantAccountId();

    /**
     * @return string
     * @since 1.0.0
     */
    public function getSecret();

    /**
     * @return string
     * @since 1.0.0
     */
    public function getBaseUrl();

    /**
     * @return string
     * @since 1.0.0
     */
    public function getHttpUser();


    /**
     * @return string
     * @since 1.0.0
     */
    public function getHttpPassword();
}
