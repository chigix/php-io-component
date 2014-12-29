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
 * A <code>FilterInputStream</code> contains some other input stream, 
 * which it uses as its basic source of data, possibly transforming the data 
 * along the way or providing additional functionality. <br>
 * The class <code>FilterInputStream</code> itself simply overrides all methods 
 * of <code>InputStream</code> with versions that pass all requests to the contained 
 * input stream. <br>
 * Subclasses of <code>FilterInputStream</code> may further override some of these 
 * methods and may provide additional methods and fields.
 *
 * @author Richard Lea <chigix@zoho.com>
 */
class FilterInputStream extends InputStream {

    /**
     *
     * @var InputStream
     */
    protected $in;

    function __construct(InputStream $in) {
        parent::__construct();
        $this->in = $in;
    }

    protected function readString($len) {
        
    }

    public function close() {
        
    }

}
