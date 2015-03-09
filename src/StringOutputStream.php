<?php

/*
 * This file is part of the io-component package.
 * 
 * (c) Richard Lea <chigix@zoho.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
