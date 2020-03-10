<?php

namespace Credentials\Config;

use Credentials\PaymentMethod;
use Credentials\PaymentMethodRegistry;
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
     * @var PaymentMethod
     */
    private $creditCardPaymentMethod;

    /**
     * ConfigFactory constructor.
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->creditCardPaymentMethod = new PaymentMethod(PaymentMethodRegistry::TYPE_CREDIT_CARD);
    }

    /**
     * @param PaymentMethod | string $paymentMethod
     * @param array $credentials
     * @return DefaultConfig|CreditCardConfig
     * @throws MissedCredentialsException
     * @since 1.0.0
     */
    public function createConfig(PaymentMethod $paymentMethod, array $credentials)
    {
        if ($paymentMethod->equalsTo($this->creditCardPaymentMethod)) {
            return new CreditCardConfig($credentials);
        }

        return new DefaultConfig($credentials);
    }

    /**
     * @param array $credentials
     * @return array
     * @throws MissedCredentialsException
     * @throws InvalidPaymentMethodException
     * @since 1.0.0
     */
    public function createConfigList(array $credentials)
    {

        $configList = [];
        foreach (array_keys($credentials) as $paymentMethodCode) {
            $paymentMethod = new PaymentMethod($paymentMethodCode);
            $configList[$paymentMethodCode] = $this->createConfig($paymentMethod, $credentials[$paymentMethodCode]);
        }
        return $configList;
    }
}
