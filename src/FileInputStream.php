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
 * A FileInputStream obtains input bytes from a file in a file system.<br>
 * What files are availabe depends on the host environment.<br>
 * 
 * FileInputStream support both raw bytes read and Characters reading. 
 * But it is not suggested to use readline for binary file.
 *
 * @author Richard Lea <chigix@zoho.com>
 */
class FileInputStream extends InputStream {

    /**
     * The file handle for reading.
     *
     * @var resource
     */
    private $readHandle;

    /**
     *
     * @var File
     */
    private $file;

    /**
     * Creates a <code>FileInputStream</code> by 
     * opening a connection to an actual file,
     * the file named by the <code>File</code> object 
     * <code>$file</code> in the file system.
     * 
     * @param File $file
     * @throws FileNotFoundException
     */
    public function __construct(File $file) {
        parent::__construct();
        $this->file = $file;
        if ($file->exists() && $file->isFile()) {
            $this->readHandle = \fopen(FileSystem::getFileSystem()->localFileName($file->getAbsolutePath()), "rb");
        } else {
            throw new FileNotFoundException($file->getAbsolutePath());
        }
    }

    protected function readString($len = 1) {
        if ($len === 1 || is_null($len) || $len < 0) {
            if (($result = fgetc($this->readHandle)) === FALSE) {
                throw new EOFException();
            } else {
                return $result;
            }
        } elseif ($len === 0) {
            return "";
        } elseif (is_int($len) && $len > 1) {
            $result = "";
            for ($i = 0; $i < $len; $i++) {
                if (($char = fgetc($this->readHandle)) === FALSE) {
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
        $line = null;
        if (is_null($len)) {
            $line = \fgets($this->readHandle);
        } else {
            $line = \fgets($this->readHandle, $len);
        }
        if ($line === FALSE) {
            if (\feof($this->readHandle)) {
                throw new EOFException;
            } else {
                throw new IOException;
            }
        }
        return \trim($line, "\n\r");
    }

    /**
     * Read all contents in the file and return as string.
     * 
     * @return string
     */
    public function readAll() {
        //$max_len = \filesize($this->file->getAbsolutePath());
        //return $this->readString($max_len);
        return \file_get_contents($this->file->getAbsolutePath());
    }

    public function close() {
        \fclose($this->readHandle);
    }
    
    function getFile() {
        return $this->file;
    }



}
