<?php

namespace Credentials;

use Credentials\Config\ConfigFactory;
use Credentials\Config\CredentialsConfigInterface;
use Credentials\Config\CredentialsCreditCardConfigInterface;
use Credentials\Exception\InvalidPaymentMethodException;
use Credentials\Reader\XMLReader;

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
     * Credentials constructor.
     * @param string $credentialsFilePath
     * @throws Exception\InvalidXMLFormatException
     * @throws Exception\InvalidPaymentMethodException
     * @throws Exception\MissedCredentialsException
     * @since 1.0.0
     */
    public function __construct($credentialsFilePath)
    {
        $this->reader = new XMLReader(file_get_contents($credentialsFilePath));
        $this->loadCredentialsConfig();
    }

    /**
     * @return Credentials
     * @throws Exception\InvalidPaymentMethodException
     * @throws Exception\MissedCredentialsException
     * @since 1.0.0
     */
    private function loadCredentialsConfig()
    {
        $this->credentialsConfig = (new ConfigFactory())->createConfigList(
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
     * @param string $paymentMethod
     * @return CredentialsConfigInterface|CredentialsCreditCardConfigInterface
     * @throws InvalidPaymentMethodException
     * @since 1.0.0
     */
    public function getCredentialsByPaymentMethod($paymentMethod)
    {
        if (!isset($this->credentialsConfig[$paymentMethod])) {
            throw new InvalidPaymentMethodException($paymentMethod);
        }
        return $this->credentialsConfig[$paymentMethod];
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
