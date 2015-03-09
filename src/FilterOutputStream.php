<?php

/*
 * This file is part of the IO-Component package.
 * 
 * (c) Richard Lea <chigix@zoho.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chigi\Component\IO;

/**
 * This class is the super class of all classes that filter output streams.
 * These streams sit on top of an already existing output stream (the <i>underlying</i>
 * output stream) which it uses as its basic sink of data, but possibly transforming 
 * the data along the way or providing additional functionality.<br>
 * 
 * The class <code>FilterOutputStream</code> itself simply overrides all methods 
 * of <code>OutputStream</code> with versions that pass all requests to 
 * the underlying output stream.
 * Subclasses of <code>FilterOutputStream</code> may further override 
 * some of these methods as well as provide additional methods and fields.
 *
 * @author Richard Lea <chigix@zoho.com>
 */
class FilterOutputStream extends OutputStream {

    protected function writeString($string) {
        
    }

    public function close() {
        
    }

    public function flush() {
        
    }

}
