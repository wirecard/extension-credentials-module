<?php


namespace Wirecard\Credentials\Reader;

/**
 * Interface FileValidatorInterface
 * @package Wirecard\Credentials\Reader
 */
interface FileValidatorInterface
{
    /**
     * @param string $filePath
     * @return bool
     */
    public function validate($filePath);
}
