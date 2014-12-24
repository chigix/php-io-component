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
    /* -- Normalization and construction -- */

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
        $path = str_replace('\\', '/', $path);
        while (strpos($path, '//') !== FALSE) {
            $path = str_replace('//', '/', $path);
        }
        $path = str_replace('./', '', $path);
        $path_exploded = explode('..', $path);
        $path = $path_exploded[0];
        for ($i = 1; $i < count($path_exploded); $i ++) {
            $path = dirname($path) . '/' . $path_exploded[$i];
        }
        $path = str_replace('//', '/', $path);
        return $path;
    }

    /**
     * Resolve the child pathname string against the parent.<br>
     * Both strings are suggested in normal form, 
     * and the result will be in normal form.
     * 
     * @param string $parent_path
     * @param string $child_path
     * @return string
     */
    public function resolve($parent_path, $child_path) {
        $real_path = null;
        if ('/' === substr($child_path, 0, 1)) {
            $real_path = $child_path;
        } elseif (preg_match('#^[a-zA-Z]:[\/\\\]#', $child_path)) {
            $real_path = $child_path;
        } else {
            if (is_dir($parent_path)) {
                // Resolve as a relative path join.
                $real_path = $parent_path . '/' . $child_path;
            } else {
                // Resolve as a file position search.
                $real_path = dirname($parent_path) . '/' . $child_path;
            }
        }
        return $this->normalize($real_path);
    }

}
