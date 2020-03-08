<?php

namespace Credentials;

use Credentials\Config\ConfigFactory;
use Credentials\Config\CreditCardConfig;
use Credentials\Config\DefaultConfig;
use Credentials\Reader\XMLReader;

class Module
{
    /**
     * @var Reader\ReaderInterface
     */
    private $reader;

    /**
     * @var array
     */
    private $credentialsConfigList = [];

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
     * @return Module
     * @throws Exception\InvalidPaymentMethodException
     * @throws Exception\MissedCredentialsException
     */
    private function loadCredentialsConfig()
    {
        $this->credentialsConfigList = (new ConfigFactory())->createConfigList(
            $this->reader->toArray()
        );
        return $this;
    }

    /**
     * @param string $paymentMethod
     * @return DefaultConfig|CreditCardConfig|DefaultConfig[]
     */
    public function getCredentials($paymentMethod = null)
    {
        $credentials = $this->credentialsConfigList;
        if (isset($this->credentialsConfigList[$paymentMethod])) {
            $credentials = $this->credentialsConfigList[$paymentMethod];
        }
        return $credentials;
    }
}
