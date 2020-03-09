<?php

namespace Credentials\Reader;

use DOMDocument;
use Credentials\Exception\InvalidXMLFormatException;

/**
 * Class XMLReader
 * @package Credentials\Reader
 * @since 1.0.0
 */
class XMLReader implements ReaderInterface
{
    /**
     * @var string
     */
    const XML_SCHEMA_FILE_NAME = "schema.xsd";

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
    }

    /**
     * @return string
     * @since 1.0.0
     */
    public function getRawXML()
    {
        return $this->rawXML;
    }

    /**
     * @return string
     * @since 1.0.0
     */
    protected function getXMLSchemaPath()
    {
        return sprintf(
            "%s/%s",
            dirname(dirname(__DIR__)),
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
        return $dom->schemaValidate($this->getXMLSchemaPath());
    }


    /**
     * @since 1.0.0
     */
    public function toArray()
    {
        $credentials = [];
        $xml = (array)simplexml_load_string($this->getRawXML());
        foreach ($xml as $paymentMethod => $credentialItem) {
            $credentials[$paymentMethod] = (array)$credentialItem;
        }

        return $credentials;
    }
}
