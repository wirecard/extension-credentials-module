<?php

namespace CredentialsReader\Credentials;

class CreditCardConfig extends DefaultConfig
{
    /**
     * @var string
     */
    const ATTRIBUTE_WPP_URL = "wpp_url";
    /**
     * @var string
     */
    const ATTRIBUTE_3D_SECRET = "three_d_secret";
    /**
     * @var string
     */
    const ATTRIBUTE_3D_MERCHANT_ACCOUNT_ID = "three_d_merchant_account_id";

    /**
     * @var string
     */
    private $wppUrl;

    /**
     * @return string
     */
    public function getWppUrl()
    {
        return $this->wppUrl;
    }

    /**
     * @return string
     */
    public function getThreeDSecret()
    {
        return $this->threeDSecret;
    }

    /**
     * @return string
     */
    public function getThreeDMerchantAccountId()
    {
        return $this->threeDMerchantAccountId;
    }

    /**
     * @param string $wppUrl
     */
    public function setWppUrl($wppUrl)
    {
        $this->wppUrl = $wppUrl;
    }

    /**
     * @param string $threeDSecret
     */
    public function setThreeDSecret($threeDSecret)
    {
        $this->threeDSecret = $threeDSecret;
    }

    /**
     * @param string $threeDMerchantAccountId
     */
    public function setThreeDMerchantAccountId($threeDMerchantAccountId)
    {
        $this->threeDMerchantAccountId = $threeDMerchantAccountId;
    }

    /**
     * @var string
     */
    private $threeDSecret;

    /**
     * @var string
     */
    private $threeDMerchantAccountId;

    /**
     * @inheritDoc
     */
    protected function requiredAttributeList()
    {
        $requiredList = parent::requiredAttributeList();
        $requiredList[] = self::ATTRIBUTE_WPP_URL;
        $requiredList[] = self::ATTRIBUTE_3D_SECRET;
        $requiredList[] = self::ATTRIBUTE_3D_MERCHANT_ACCOUNT_ID;
        return $requiredList;
    }

    /**
     * @param array $credentials
     */
    protected function loadFromCredentials(array $credentials)
    {
        parent::loadFromCredentials($credentials);
        $this->setWppUrl($credentials[self::ATTRIBUTE_WPP_URL]);
        $this->setThreeDMerchantAccountId($credentials[self::ATTRIBUTE_3D_MERCHANT_ACCOUNT_ID]);
        $this->setThreeDSecret($credentials[self::ATTRIBUTE_3D_SECRET]);
    }
}
