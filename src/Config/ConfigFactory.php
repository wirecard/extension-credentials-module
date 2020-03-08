<?php

namespace Credentials\Config;

use Credentials\Constants\PaymentMethod;
use Credentials\Exception\InvalidPaymentMethodException;
use Credentials\Exception\MissedCredentialsException;

class ConfigFactory
{
    /**
     * @param $paymentMethodType
     * @param array $credentials
     * @return DefaultConfig|CreditCardConfig
     * @throws InvalidPaymentMethodException
     * @throws MissedCredentialsException
     */
    public function createConfig($paymentMethodType, array $credentials)
    {
        if (!in_array($paymentMethodType, PaymentMethod::availablePaymentMethods())) {
            throw new InvalidPaymentMethodException($paymentMethodType);
        }

        if ($paymentMethodType === PaymentMethod::TYPE_CREDIT_CARD) {
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
        foreach ($credentials as $paymentMethod => $data) {
            $configList[$paymentMethod] = $this->createConfig($paymentMethod, $data);
        }
        return $configList;
    }
}
