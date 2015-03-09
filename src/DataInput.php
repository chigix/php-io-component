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
 * The DataInput Interface provides for reading bytes from a binary stream and 
 * reconstructing from them data in any of the Java primitive types.<br>
 * There is also a facility for reconstructing a String from data in modified UTF-8 format.<br>
 * It is generally true of all the reading routings in this interface that 
 * if end of file is reached before the desired number of bytes has been read, 
 * and EOFException is thrown.<br>
 * In particular, an IOException may be thrown if the input stream has been closed.
 * @author Richard Lea <chigix@zoho.com>
 */
interface DataInput {

    /**
     * Reads some byte from an input stream and return them.
     * @param int $offset
     * @param int $len
     * @throws EOFException
     * @throws IOException
     */
    function readFully($offset, $len);
}
