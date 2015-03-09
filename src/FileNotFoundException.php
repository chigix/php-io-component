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
 * Signals that an attempt to open the file denoted by a specified pathname has failed.
 *
 * @author Richard Lea <chigix@zoho.com>
 */
class FileNotFoundException extends IOException {

    /**
     * Constructor.
     *
     * @param string $path The path to the file that was not found
     */
    public function __construct($path) {
        parent::__construct(sprintf('The file "%s" does not exist', $path));
    }

}
