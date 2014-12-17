<?php

namespace Chigi\Component\IO;

/**
 * The STDIN input stream.<br>
 * This stream is already open and ready to supply input data.<br>
 * And the instance is singleton.
 *
 * @author Richard Lea <chigix@zoho.com>
 */
class StdInputStream extends InputStream {

    public static function getInstance() {
        static $instance = null;
        if (is_null($instance)) {
            $instance = new StdInputStream();
        }
        return $instance;
    }

    protected function __construct() {
        parent::__construct();
    }

    protected function readString($len = 1) {
        if ($len === 1 || is_null($len) || $len < 0) {
            if (($result = fgetc(STDIN)) === FALSE) {
                throw new EOFException();
            } else {
                return $result;
            }
        } elseif ($len === 0) {
            return "";
        } elseif (is_int($len) && $len > 1) {
            $result = "";
            for ($i = 0; $i < $len; $i++) {
                if (($char = fgetc(STDIN)) === FALSE) {
                    if ($i === 0) {
                        throw new EOFException();
                    }
                    break;
                } else {
                    $result .= $char;
                }
            }
            return $result;
        } else {
            throw new \InvalidArgumentException('Invalid $len param:' . $len);
        }
    }

    public function readLine($len = null) {
        if (is_int($len) && $len > 0) {
            $line = fgets(STDIN, $len);
        } else {
            $line = fgets(STDIN);
        }
        if ($line === FALSE) {
            throw new EOFException();
        } else {
            return $line;
        }
    }

    public function close() {
        
    }

}
