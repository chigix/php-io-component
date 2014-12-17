<?php

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
