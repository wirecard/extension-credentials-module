<?php


namespace Wirecard\Credentials\Reader;

use DOMDocument;
use Exception;
use Wirecard\Credentials\Exception\InvalidXMLFormatException;

class XMLFileValidator implements FileValidatorInterface
{
    /**
     * @var string
     */
    const XML_SCHEMA_FILE_NAME = "schema.xsd";

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
     * @param string $filePath
     * @param bool $throwError
     * @return bool
     * @throws InvalidXMLFormatException
     */
    public function validate($filePath, $throwError = true)
    {
        try {
            $dom = new DOMDocument();
            $dom->load($filePath);
            $result = $dom->schemaValidate($this->getXMLSchemaPath());
        } catch (Exception $e) {
            if ($throwError) {
                throw new InvalidXMLFormatException($e->getMessage());
            }
            $result = false;
        }

        return $result;
    }
}
