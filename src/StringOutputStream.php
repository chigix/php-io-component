<?php

namespace Chigi\Component\IO;

/**
 * A character stream that collects its output in a string buffer, 
 * which can then be used to construct a string.
 *
 * @author Richard Lea <chigix@zoho.com>
 */
class StringOutputStream extends OutputStream {

    /**
     *
     * @var string
     */
    private $str;

    function __construct($str = "") {
        $this->str = $str;
        if (!is_string($this->str)) {
            $this->str = $str;
        }
    }

    protected function writeString($string) {
        $this->str .= $string;
    }

    public function close() {
        
    }

    public function flush() {
        
    }

}
