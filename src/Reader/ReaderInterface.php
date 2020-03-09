<?php

namespace Credentials\Reader;

/**
 * Interface ReaderInterface
 * @package Credentials\Reader
 * @since 1.0.0
 */
interface ReaderInterface
{
    /**
     * @return array
     * @since 1.0.0
     */
    public function toArray();

    /**
     * @return bool
     * @since 1.0.0
     */
    public function validate();
}
