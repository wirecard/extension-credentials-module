<?php

namespace Credentials\Config;

use Credentials\Constants\PaymentMethod;
use Credentials\Exception\InvalidPaymentMethodException;
use Credentials\Exception\MissedCredentialsException;

class ConfigFactory
{
    /**
     * @param $paymentMethod
     * @param array $credentials
     * @return DefaultConfig|CreditCardConfig
     * @throws InvalidPaymentMethodException
     * @throws MissedCredentialsException
     */
    public function createConfig($paymentMethod, array $credentials)
    {
        if (!in_array($paymentMethod, PaymentMethod::availablePaymentMethods())) {
            throw new InvalidPaymentMethodException($paymentMethod);
        }

        if ($paymentMethod === PaymentMethod::TYPE_CREDIT_CARD) {
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
