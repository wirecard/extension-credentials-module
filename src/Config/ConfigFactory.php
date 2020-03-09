<?php

namespace Credentials\Config;

use Credentials\Constants\PaymentMethodRegistry;
use Credentials\Exception\InvalidPaymentMethodException;
use Credentials\Exception\MissedCredentialsException;

/**
 * Class ConfigFactory
 * @package Credentials\Config
 * @SuppressWarnings(PHPMD.LongVariable)
 * @since 1.0.0
 */
class ConfigFactory
{
    /**
     * @var array
     */
    private $availablePaymentMethods = [];

    /**
     * @return array
     * @since 1.0.0
     */
    protected function getAvailablePaymentMethods()
    {
        if (empty($this->availablePaymentMethods)) {
            $paymentMethodRegistry = new PaymentMethodRegistry();
            $this->availablePaymentMethods = $paymentMethodRegistry->availablePaymentMethods();
        }
        return $this->availablePaymentMethods;
    }

    /**
     * @param string $paymentMethod
     * @param array $credentials
     * @return DefaultConfig|CreditCardConfig
     * @throws InvalidPaymentMethodException
     * @throws MissedCredentialsException
     * @since 1.0.0
     */
    public function createConfig($paymentMethod, array $credentials)
    {
        if (!in_array($paymentMethod, $this->getAvailablePaymentMethods())) {
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
     * @since 1.0.0
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
