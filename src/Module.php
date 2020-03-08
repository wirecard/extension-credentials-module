<?php

namespace CredentialsReader;

use CredentialsReader\Credentials\ConfigFactory;
use CredentialsReader\Credentials\CreditCardConfig;
use CredentialsReader\Credentials\DefaultConfig;
use CredentialsReader\Reader\XMLReader;

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
     * @return array
     * @throws Exception\InvalidPaymentMethodException
     * @throws Exception\MissedCredentialsException
     */
    private function loadCredentialsConfig()
    {
        if (is_null($this->credentialsConfigList)) {
            $this->credentialsConfigList = (new ConfigFactory())->createConfigList(
                $this->reader->getCredentials()
            );
        }
        return $this->credentialsConfigList;
    }

    /**
     * @param string $paymentMethod
     * @return DefaultConfig|CreditCardConfig
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
