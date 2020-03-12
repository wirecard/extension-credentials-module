<?php
/**
 * Shop System Extensions:
 * - Terms of Use can be found at:
 * https://github.com/wirecard/extension-credentials-module/blob/master/_TERMS_OF_USE
 * - License can be found under:
 * https://github.com/wirecard/extension-credentials-module/blob/master/LICENSE
 */

namespace Wirecard\Credentials\Reader;

use DOMDocument;
use Exception;
use Wirecard\Credentials\Exception\InvalidXMLFormatException;

/**
 * Class XMLFileValidator
 * @package Wirecard\Credentials\Reader
 */
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
     * @since 1.0.0
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
