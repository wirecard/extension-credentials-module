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
     * @var PaymentMethodRegistry
     */
    private $paymentMethodRegistry;

    /**
     * ConfigFactory constructor.
     * @param PaymentMethodRegistry $paymentMethodRegistry
     * @since 1.0.0
     */
    public function __construct(PaymentMethodRegistry $paymentMethodRegistry)
    {
        $this->paymentMethodRegistry = $paymentMethodRegistry;
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
        if ($paymentMethod->equalsTo(PaymentMethodRegistry::TYPE_CREDIT_CARD)) {
            return new CreditCardConfig($paymentMethod, $credentials);
        }

        return new DefaultConfig($paymentMethod, $credentials);
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
        foreach ($credentials as $type => $credentialItem) {
            $paymentMethod = $this->paymentMethodRegistry->getPaymentMethod($type);
            $configList[(string)$paymentMethod] = $this->createConfig($paymentMethod, $credentialItem);
        }
        return $configList;
    }
}
