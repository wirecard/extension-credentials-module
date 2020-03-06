<?php

namespace CredentialsReader\Reader;

class XMLReader implements ReaderInterface
{
    /** @var array */
    private $credentials = [];

    /** @var string */
    private $data;

    /**
     * XMLReader constructor.
     * @param $data
     * @since 1.0.0
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->validate();
        $this->processData();
    }

    /**
     * Validate XML with XSD schema
     * @since 1.0.0
     */
    protected function validate()
    {
        return false;
    }

    /**
     * @return $this
     * @since 1.0.0
     */
    protected function processData()
    {
        if (!empty($this->data)) {
            $xml = (array)simplexml_load_string($this->data);
            foreach ($xml as $paymentMethod => $credentials) {
                $this->credentials[$paymentMethod] = (array)$credentials;
            }
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getCredentials()
    {
        return $this->credentials;
    }
}
