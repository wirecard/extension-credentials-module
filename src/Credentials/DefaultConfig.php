<?php

namespace CredentialsReader\Credentials;

use CredentialsReader\Exception\MissedCredentialsException;

class DefaultConfig
{
    /**
     * @var string
     */
    const ATTRIBUTE_MERCHANT_ACCOUNT_ID = 'merchant_account_id';

    /**
     * @var string
     */
    const ATTRIBUTE_BASE_URL = "base_url";

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $merchantAccountId;

    /**
     * BaseConfig constructor.
     * @param array $credentials
     * @throws MissedCredentialsException
     */
    public function __construct(array $credentials)
    {
        $missedKeys = array_diff($this->requiredAttributeList(), array_keys($credentials));
        if (count($missedKeys) > 0) {
            throw new MissedCredentialsException(implode(", ", array_values($missedKeys)) . " are required!");
        }
        $this->loadFromCredentials($credentials);
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return string
     */
    public function getMerchantAccountId()
    {
        return $this->merchantAccountId;
    }

    /**
     * @return array
     */
    protected function requiredAttributeList()
    {
        return [
            self::ATTRIBUTE_MERCHANT_ACCOUNT_ID,
            self::ATTRIBUTE_BASE_URL,
        ];
    }

    /**
     * @param array $credentials
     */
    protected function loadFromCredentials(array $credentials)
    {
        $this->baseUrl = $credentials[self::ATTRIBUTE_BASE_URL];
        $this->merchantAccountId = $credentials[self::ATTRIBUTE_MERCHANT_ACCOUNT_ID];
    }
}
