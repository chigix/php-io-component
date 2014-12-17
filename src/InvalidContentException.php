<?php

namespace Chigi\Component\IO;

/**
 * Indicates that one or more content failed string convertion.
 *
 * @author Richard Lea <chigix@zoho.com>
 */
class InvalidContentException extends IOException {

    public function __construct($message, $code, $previous) {
        parent::__construct($message, $code, $previous);
    }

}
