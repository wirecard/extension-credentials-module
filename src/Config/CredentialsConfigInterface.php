<?php

namespace Credentials\Config;

interface CredentialsConfigInterface
{
    /**
     * @return string
     */
    public function getMerchantAccountId();

    /**
     * @return string
     */
    public function getSecret();

    /**
     * @return string
     */
    public function getBaseUrl();

    /**
     * @return string
     */
    public function getHttpUser();


    /**
     * @return string
     */
    public function getHttpPassword();
}
