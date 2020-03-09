<?php

namespace Credentials\Config;

use Credentials\Constants\PaymentMethodRegistry;
use Credentials\Exception\InvalidPaymentMethodException;
use Credentials\Exception\MissedCredentialsException;

/**
 * Class ConfigFactory
 * @package Credentials\Config
 */
class ConfigFactory
{
    /**
     * @param $paymentMethod
     * @param array $credentials
     * @return DefaultConfig|CreditCardConfig
     * @throws InvalidPaymentMethodException
     * @throws MissedCredentialsException
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function createConfig($paymentMethod, array $credentials)
    {
        if (!in_array($paymentMethod, (new PaymentMethodRegistry())->availablePaymentMethods())) {
            throw new InvalidPaymentMethodException($paymentMethod);
        }

        if ($paymentMethod === PaymentMethodRegistry::TYPE_CREDIT_CARD) {
            return new CreditCardConfig($credentials);
        }

        return new DefaultConfig($credentials);
    }

    /**
     * @param array $credentials
     * @return array
     * @throws InvalidPaymentMethodException
     * @throws MissedCredentialsException
     */
    public function createConfigList(array $credentials)
    {
        $configList = [];
        foreach ($credentials as $paymentMethod => $credentialItem) {
            $configList[$paymentMethod] = $this->createConfig($paymentMethod, $credentialItem);
        }
        return $configList;
    }
}
