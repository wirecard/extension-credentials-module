<?php

namespace Credentials\Reader;

use Credentials\PaymentMethodRegistry;
use Credentials\Exception\InvalidXMLFormatException;
use Exception;

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
        try {
            if (!$this->validate()) {
                throw new InvalidXMLFormatException();
            }
        } catch (Exception $ex) {
            throw new InvalidXMLFormatException($ex->getMessage());
        }
    }

    /**
     * @return string
     * @since 1.0.0
     */
    private function getXMLSchemaPath()
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
    private function validate()
    {
        $dom = new \DOMDocument();
        $dom->loadXML($this->rawXML);
        return $dom->schemaValidate($this->getXMLSchemaPath());
    }


    /**
     * @since 1.0.0
     */
    public function toArray()
    {
        $credentials = [];
        $domDocument = new \DOMDocument();
        $domDocument->loadXML($this->rawXML);
        $xPath = new \DOMXPath($domDocument);
        foreach (PaymentMethodRegistry::availablePaymentMethods() as $paymentMethod) {
            if (!$paymentMethodXPath = $xPath->query(
                "/config/payment_methods/{$paymentMethod}"
            )->item(0)) {
                continue;
            }
            /** @var \DOMNode $child */
            foreach ($paymentMethodXPath->childNodes as $child) {
                if ($child->nodeType != XML_ELEMENT_NODE) {
                    continue;
                }
                $credentials[$paymentMethod][$child->nodeName] = $child->nodeValue;
            }
        }

        return $credentials;
    }
}
