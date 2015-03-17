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

use Symfony\Component\Filesystem\Filesystem as SfFilesystem;

/**
 * Package-private class for the local filesystem operation.
 *
 * @author Richard Lea <chigix@zoho.com>
 */
class FileSystem extends SfFilesystem {

    /**
     * Return the FileSystem object representing this platform's local filesystem. 
     * 
     * @staticvar FileSystem $instance
     * @return FileSystem
     */
    public static function getFileSystem() {
        static $instance = null;
        if (is_null($instance)) {
            $instance = new FileSystem();
        }
        return $instance;
    }

    /* -- Normalization and construction -- */

    /**
     * The FileSystem Charset name.
     *
     * @var string
     */
    private $charset;

    private function __construct() {
        $this->charset = "UTF-8";
    }

    /**
     * Set the Current System Charset name.<br>
     * IMPORTANT: This method must be called at the begining 
     * prevending unexpected file path error.
     * 
     * @param string $charset
     * @return FileSystem
     */
    public function setCharset($charset) {
        $this->charset = $charset;
        return $this;
    }

    /**
     * Get the current system charset name.<br>
     * IMPORTANT: This method must be called after 
     * <code>setCharset</code> confirmation, 
     * or returns "UTF-8", the default.
     * 
     * @return string
     */
    private function getCharset() {
        return $this->charset;
    }

    /**
     * Return the local filesystem's name-separator character.<br>
     * For Windows the char is `\` and others is `/` generally.
     * 
     * @return string
     */
    public function getSeparator() {
        return DIRECTORY_SEPARATOR;
    }

    /**
     * Return the local filesystem's path-separator character.<br>
     * Generally, the character is `:`.
     * 
     * @return string
     */
    public function getPathSeparator() {
        return PATH_SEPARATOR;
    }

    /**
     * Convert the given pathname string to normal form.<br>
     * If the string is already in normal form then it is simply returned.
     * 
     * @param string $path An abstract pathname.
     * @return string The normalized path string.
     */
    public function normalize($path) {
        $path = strtr(trim($path), '\\', '/');
        $scheme = "";
        $matches = array();
        if (preg_match('#([a-zA-Z]+:/)/(.+)#', $path, $matches)) {
            $scheme = $matches[1];
            $path = "/" . $matches[2];
        }
        $result = substr(
                array_reduce(
                        explode('/', $path)
                        , create_function('$a, $b', '
                            if($a === 0){
                                    if($b === "." 
                                        || $b === ".." 
                                        || substr($b,1,1) === ":" 
                                        || $b === ""){
                                        return preg_replace("/\/+/", "/", "$b/");
                                    } else {
                                        return preg_replace("/\/+/", "/", "./$b/");
                                    }
                            }
                            if($b === "" || $b === "."){
                                    return preg_replace("/\/+/", "/", "$a/");
                            }
                            if($b === ".." && substr($a, -4) === "/../"){
                                    return preg_replace("/\/+/", "/", "$a/$b/");
                            }
                            if($b === ".." && $a === "../"){
                                    return preg_replace("/\/+/", "/", "$a/$b/");
                            }
                            if($b === ".." && $a === "./"){
                                    return "../";
                            }
                            if($b === ".." && $a === "/"){
                                    return "//";
                            }
                            if($b === ".."){
                                    return preg_replace("/\/+/", "/", strtr(dirname($a), \'\\\\\', \'/\') . "/");
                            }
                            return preg_replace("/\/+/", "/", "$a/$b/");
                        ')
                        , 0)
                , 0, -1);
        return $scheme . ($result === "" ? "/" : $result);
    }

    /**
     * Resolve the child pathname string against the parent.<br>
     * Both strings are suggested in normal form, 
     * and the result will be in normal form.
     * 
     * @param string $parent_path
     * @param string $child_path
     * @return string
     * @throws \InvalidArgumentException
     */
    public function resolve($parent_path, $child_path) {
        if (!is_string($parent_path)) {
            throw new \InvalidArgumentException("The first path param must be string.");
        }
        if (!is_string($child_path)) {
            throw new \InvalidArgumentException("The child Path param must be string.");
        }
        $real_path = null;
        if ('/' === substr($child_path, 0, 1)) {
            $real_path = $child_path;
        } elseif (preg_match('#^[a-zA-Z]:[\/\\\]#', $child_path)) {
            $real_path = $child_path;
        } else {
            if (\is_dir($parent_path)) {
                // Resolve as a relative path join.
                $real_path = $parent_path . '/' . $child_path;
            } else {
                // Resolve as a file position search.
                $real_path = dirname($parent_path) . '/' . $child_path;
            }
        }
        return $this->normalize($real_path);
    }

    /**
     * Tells whether the filename is a regular file.
     * 
     * @param string $file_name the filename string in UTF-8 encoding.
     * @return bool
     */
    public function isFile($file_name) {
        return \is_file($this->localFileName($file_name));
    }

    /**
     * Tells whether the filename is a directory.
     * 
     * @param string $file_name The filename string in UTF-8 encoding.
     * @return boolean
     */
    public function isDirectory($file_name) {
        return \is_dir($this->localFileName($file_name));
    }

    /**
     * Returns the filename encoded to the local file system.
     * 
     * @param string $file_name
     * @return string
     */
    public function localFileName($file_name) {
        return \iconv("utf-8", $this->charset, $file_name);
    }

}
