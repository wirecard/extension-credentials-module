<?php

namespace Credentials;

use Credentials\Config\ConfigFactory;
use Credentials\Config\CredentialsConfigInterface;
use Credentials\Config\CredentialsCreditCardConfigInterface;
use Credentials\Reader\XMLReader;

/**
 * Class Credentials
 * @package Credentials
 * @since 1.0.0
 */
class Credentials
{
    /**
     * @var Reader\ReaderInterface
     */
    private $reader;

    /**
     * @var array|CredentialsConfigInterface[]|CredentialsCreditCardConfigInterface[]
     */
    private $credentialsConfig = [];


    /**
     * @var PaymentMethodRegistry
     */
    private $paymentMethodRegistry;

    /**
     * Credentials constructor.
     * @param string $credentialsFilePath
     * @throws Exception\InvalidXMLFormatException
     * @throws Exception\InvalidPaymentMethodException
     * @throws Exception\MissedCredentialsException
     * @since 1.0.0
     */
    public function __construct($credentialsFilePath)
    {
        $this->reader = new XMLReader(
            file_get_contents($credentialsFilePath),
            $this->getPaymentMethodRegistry()
        );
        $this->loadCredentialsConfig();
        echo "<pre>";
        print_r($this);
        echo "</pre>";
        die;
    }

    /**
     * @return Credentials
     * @throws Exception\MissedCredentialsException
     * @throws Exception\InvalidPaymentMethodException
     * @since 1.0.0
     */
    private function loadCredentialsConfig()
    {
        $credentialsConfigFactory = new ConfigFactory($this->getPaymentMethodRegistry());
        $this->credentialsConfig = $credentialsConfigFactory->createConfigList(
            $this->getReader()->toArray()
        );
        return $this;
    }

    /**
     * @return Reader\ReaderInterface
     * @since 1.0.0
     */
    public function getReader()
    {
        return $this->reader;
    }


    /**
     * @return PaymentMethodRegistry
     * @throws Exception\InvalidPaymentMethodException
     */
    public function getPaymentMethodRegistry()
    {
        if (is_null($this->paymentMethodRegistry)) {
            $this->paymentMethodRegistry = new PaymentMethodRegistry();
        }
        return $this->paymentMethodRegistry;
    }

    /**
     * @param PaymentMethod | string $paymentMethod
     * @return CredentialsConfigInterface|CredentialsCreditCardConfigInterface
     * @since 1.0.0
     */
    public function getCredentialsByPaymentMethod(PaymentMethod $paymentMethod)
    {
        return $this->credentialsConfig[(string)$paymentMethod];
    }

    /**
     * @return array|CredentialsConfigInterface[]|CredentialsCreditCardConfigInterface[]
     * @since 1.0.0
     */
    public function getCredentials()
    {
        return $this->credentialsConfig;
    }
}
