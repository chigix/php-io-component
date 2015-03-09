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
 * This abstract class is the superclass of all classes representing an outputstream of string. <br>
 * An output stream accepts output string and sends them to some sink.<br>
 * 
 * Applications that need to define a subclass of OutputStream must always
 * provide at least a method that writes one string of output.
 *
 * @author Richard Lea <chigix@zoho.com>
 */
abstract class OutputStream {

    public abstract function close();

    public abstract function flush();

    /**
     * Writes the specified string to this output stream.<br>
     * @param string $string The string to write.
     */
    protected abstract function writeString($string);

    /**
     * Writes The provided content to this output stream.
     * @param mixed $content
     * @throws InvalidContentException
     */
    public function write($content) {
        if (is_string($content) || is_numeric($content)) {
            $this->writeString($content);
        } elseif (is_bool($content)) {
            $this->writeString($content ? "TRUE" : "FALSE");
        } elseif (is_array($content)) {
            $this->writeString("Array(" . count($content) . ")");
        } elseif (is_object($content) && method_exists($content, "__toString")) {
            $this->writeString(strval($content));
        } elseif (is_null($content)) {
            $this->writeString("NULL");
        } elseif (is_resource($content)) {
            $this->writeString("Resource###");
        } else {
            throw new InvalidContentException();
        }
    }

    /**
     * Writes the Provided content to this output stream 
     * and then terminates the line.
     * @param type $content
     * @throws InvalidContentException
     * @throws IOException
     */
    public function writeln($content) {
        $this->write($content);
        $this->write("\n");
    }

}
