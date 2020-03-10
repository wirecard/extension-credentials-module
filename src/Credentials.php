<?php

namespace Credentials;

use Credentials\Config\ConfigFactory;
use Credentials\Config\CredentialsConfigInterface;
use Credentials\Config\CredentialsContainer;
use Credentials\Config\CredentialsCreditCardConfig;
use Credentials\Reader\XMLReader;
use RuntimeException;

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
     * @var array|CredentialsConfigInterface[]|CredentialsCreditCardConfig[]
     */
    private $config = [];

    /**
     * Credentials constructor.
     * @param string $credentialsFilePath
     * @throws Exception\InvalidXMLFormatException
     * @since 1.0.0
     */
    public function __construct($credentialsFilePath)
    {
        if (!is_readable($credentialsFilePath)) {
            throw new RuntimeException("File is not readable: " . $credentialsFilePath);
        }
        $this->reader = new XMLReader(
            file_get_contents($credentialsFilePath)
        );
    }

    /**
     * @param PaymentMethod | string $paymentMethod
     * @return CredentialsConfigInterface|CredentialsCreditCardConfig
     * @throws Exception\InvalidPaymentMethodException
     * @throws Exception\MissedCredentialsException
     * @since 1.0.0
     */
    public function getConfigByPaymentMethod(PaymentMethod $paymentMethod)
    {
        $config = $this->getConfig();
        return $config[(string)$paymentMethod];
    }

    /**
     * @return CredentialsConfigInterface[]|CredentialsCreditCardConfig[]|CredentialsContainer[]
     * @throws Exception\InvalidPaymentMethodException
     * @throws Exception\MissedCredentialsException
     * @since 1.0.0
     */
    public function getConfig()
    {
        if (empty($this->config)) {
            $this->config = (new ConfigFactory())->createConfigList(
                $this->reader->toArray()
            );
        }
        return $this->config;
    }
}
