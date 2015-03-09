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
 * A closeable is a source or destination of data that can be closed.<br>
 * The close method is invoked to release resources 
 * that the object is holding(such as open files).
 * @author Richard Lea <chigix@zoho.com>
 */
interface Closeable {

    /**
     * Closes this stream and releases any system resources associated with it.
     * @throws IOException
     */
    function close();
}
