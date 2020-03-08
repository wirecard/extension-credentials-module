<?php

namespace Credentials\Config;

interface CredentialsCreditCardConfigInterface
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
