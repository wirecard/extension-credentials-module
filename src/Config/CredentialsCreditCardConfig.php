<?php
/**
 * Shop System Extensions:
 * - Terms of Use can be found at:
 * https://github.com/wirecard/extension-credentials-module/blob/master/_TERMS_OF_USE
 * - License can be found under:
 * https://github.com/wirecard/extension-credentials-module/blob/master/LICENSE
 */

namespace Wirecard\Credentials\Config;

/**
 * Interface CredentialsCreditCardConfigInterface
 * @package Credentials\Config
 * @since 1.0.0
 */
interface CredentialsCreditCardConfig extends CredentialsConfigInterface
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
