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
     * App constructor.
     * @param $credentialsFilePath
     * @throws Exception\InvalidXMLFormatException
     * @throws Exception\InvalidPaymentMethodException
     * @throws Exception\MissedCredentialsException
     */
    public function __construct($credentialsFilePath)
    {
        $this->reader = new XMLReader(file_get_contents($credentialsFilePath));
        $this->loadCredentialsConfig();
    }

    /**
     * @return Reader\ReaderInterface
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * @return Credentials
     * @throws Exception\InvalidPaymentMethodException
     * @throws Exception\MissedCredentialsException
     */
    private function loadCredentialsConfig()
    {
        $this->credentialsConfig = (new ConfigFactory())->createConfigList(
            $this->getReader()->toArray()
        );
        return $this;
    }

    /**
     * @param string $paymentMethod
     * @return CredentialsConfigInterface|CredentialsCreditCardConfigInterface
     * @throws InvalidPaymentMethodException
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
     */
    public function getCredentials()
    {
        return $this->credentialsConfig;
    }
}
