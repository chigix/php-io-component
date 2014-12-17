<?php

namespace Chigi\Component\IO;

/**
 * This abstract class is the super class of all classes representing an input stream of bytes.<br>
 * Applications that need to define a subclass of InputStream must always provide a method that returns the next byte of input.
 *
 * @author Richard Lea <chigix@zoho.com>
 */
abstract class InputStream {

    /**
     * The Charset Encoding name.
     * @var string
     */
    private $charsetName;

    protected function __construct() {
        $this->charsetName = "UTF-8";
    }

    /**
     * Closes the stream and releases any system resources associated with it.
     */
    abstract public function close();

    /**
     * Reads a string and return.
     * @return string The string read.
     * @throws EOFException
     * @throws IOException
     */
    abstract protected function readString($len);

    /**
     * Reads a string in specified length and return.
     * @param int $len
     * @return string
     * @throws EOFException
     */
    public function read($len = 1) {
        if ($len < 0) {
            $len = 1;
        } elseif ($len == 0) {
            return "";
        }
        return $this->readString($len);
    }

    /**
     * Reading ends when length-1 bytes have been read,
     * or a new line (which is included in the return value),
     * or an EOF (whichever comes first).<br>
     * If no length is specified, it will keep reading from the stream 
     * until it reaches the end of the line.
     * @param int $len
     * @return string The String Read.
     * @throws EOFException
     * @throws IOException
     */
    public function readLine($len = null) {
        $line = "";
        if ($len < 0) {
            $len = null;
        } elseif ($len == 0) {
            return $line;
        }
        $count = 0;
        while (true) {
            try {
                $char = $this->readString(1);
            } catch (EOFException $exc) {
                throw $exc;
            }
            if (in_array($char, array("\n", "\r"))) {
                break;
            }
            $line .= $char;
            if ($count == $len - 1) {
                break;
            }
        }
        return $line;
    }

    /**
     * Returns the name of the character encoding being used by this stream.
     * @return string
     */
    public function getEncoding() {
        return $this->charsetName;
    }

    /**
     * Tells whether this stream is ready to be read.
     * @return boolean
     */
    public function ready() {
        return TRUE;
    }

}
