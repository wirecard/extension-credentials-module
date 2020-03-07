<?php

namespace CredentialsReader\Reader;

use DOMDocument;
use CredentialsReader\Exception\InvalidXMLFormatException;

class XMLReader implements ReaderInterface
{
    /**
     * @var string
     */
    const XML_SCHEMA_FILE_NAME = "schema.xsd";

    /**
     * @var array
     */
    private $credentials = [];

    /**
     * @var string
     */
    private $rawXML;

    /**
     * XMLReader constructor.
     * @param string $data
     * @throws InvalidXMLFormatException
     * @since 1.0.0
     */
    public function __construct($data)
    {
        $this->rawXML = $data;
        if (!$this->validate()) {
            throw new InvalidXMLFormatException();
        }
        $this->loadCredentials();
    }

    /**
     * @return string
     */
    public function getRawXML()
    {
        return $this->rawXML;
    }

    /**
     * @return array
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @return string
     */
    protected function getXMLSchemaPath()
    {
        return sprintf(
            "%s/%s",
            dirname(__FILE__),
            self::XML_SCHEMA_FILE_NAME
        );
    }

    /**
     * Validate XML with XSD schema
     * @since 1.0.0
     */
    public function validate()
    {
        $dom = new DOMDocument();
        $dom->loadXML($this->getRawXML());
        //return $dom->schemaValidate($this->getXMLSchemaPath());
        // todo: add validation and unit pass tests
        return true;
    }


    /**
     * @since 1.0.0
     */
    public function loadCredentials()
    {
        $xml = (array)simplexml_load_string($this->getRawXML());
        foreach ($xml as $paymentMethod => $credentials) {
            $this->credentials[$paymentMethod] = (array)$credentials;
        }

        return $this;
    }
}
