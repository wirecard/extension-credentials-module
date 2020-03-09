<?php

namespace Credentials\Reader;

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
