<?php

namespace Credentials\Reader;

interface ReaderInterface
{
    /**
     * @return array
     */
    public function toArray();

    /**
     * @return bool
     */
    public function validate();
}
