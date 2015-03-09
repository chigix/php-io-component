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

use InvalidArgumentException;

/**
 * An abstract representation of file and directory pathnames.
 * 
 * User interfaces and operating systems use system-dependent pathname strings to name files and directories.<br>
 * This class presents and abstract, system-independent view of hierarchical pathnames.
 *
 * @author Richard Lea <chigix@zoho.com>
 */
class File {

    /**
     * The realpath of this file.
     * @var string
     */
    private $absolutePath;

    /**
     * This abstract pathname's normalized pathname string.<br>
     * A normalized pathname string uses the default name-separator character 
     * and does not contain any duplicate or redundant separators.
     * @var string
     */
    private $path;

    /**
     * Creates a new <code>File</code> instance by converting the
     * given pathname string into an abstract pathname.<br>
     * If the given string is the empty string then the result is the empty abstract pathname.<br>
     * The abstract path of this file instace if just the path string normalized 
     * upon given path.
     * 
     * @param string $path
     * @param string $parent_path
     * @throws InvalidArgumentException
     */
    function __construct($path, $parent_path = "") {
        if (!is_string($path)) {
            throw new InvalidArgumentException("The first path param must be string.");
        }
        if (!is_string($parent_path)) {
            throw new InvalidArgumentException("The parent path param must be string.");
        }
        if ($parent_path === "") {
            $parent_path = \getcwd();
        }
        $this->path = FileSystem::getFileSystem()->normalize($path);
        $this->absolutePath = FileSystem::getFileSystem()->resolve($parent_path, $this->path);
        $this->path = $path;
    }

    /**
     * Returns the name of the file or directory denotede by this abstract pathname.<br>
     * This is just the last name in the pathname's name sequence.
     * If the pathname's name sequence is empty, then the empty string is returned.
     * 
     * @return string The name of the file or directory denoeted by this abstract pathname,
     *                 or the empty string if this pathname's name sequence is empty.
     */
    public function getName() {
        return \basename($this->path);
    }

    /**
     * Returns the absolute pathname string of this abstract pathname.<br>
     * <li> If this abstract pathname is already absolute, then 
     * the pathname string is simply returned as if by the <code>{@link getPath}</code> method.</li>
     * <li>If this abstract pathname is the empty abstract pathname then 
     * the pathname string of the current user directory, which is named by the system function 
     * <code>{@link \getcwd()}</code>, is returned.</li>
     * <li>Otherwise this pathname is resolved in a system-dependent way. 
     * On Unix Systems, a relative pathname is made absolute by resolving it 
     * against the current user directory. On Microsoft Windows Systems, 
     * a relative pathname is made absolute by resolving it against the current directory 
     * of the drive named by the pathname, if any; if not, it is resolved against the current user directory.</li>
     * 
     * @return string
     */
    public function getAbsolutePath() {
        return $this->absolutePath;
    }

    /**
     * Returns the absolute form of this abstract pathname. Equivalent to 
     * <code>new File(this.getAbsolute())</code>.
     * 
     * @return File The absolute abstract pathname denoting 
     *               the same file or directory as this abstract pathname.
     */
    public function getAbsoluteFile() {
        return new File($this->absolutePath);
    }

    /**
     * Returns the length of the file denoted by this abstract pathname.<br>
     * The return value is unspecified if this pathname denotes a directory.
     * 
     * @return int The length, in bytes, of the file denoted by this abstract pathname, 
     *              or <code>0</code> if the file does not exist. Some operating systems 
     *              may return <code>0</code> for pathnames denoting system-dependent entities 
     *              such as devices or pipes.
     */
    public function length() {
        return \filesize($this->absolutePath);
    }

    /**
     * Tests whether the file or directory denoted by this abstract pathname 
     * exists.
     * 
     * @return boolean <code>True</code> if and only if the file or directory 
     *                  denoted by this abstract pathname exists; 
     *                  <code>False</code> otherwise.
     */
    public function exists() {
        return \file_exists(FileSystem::getFileSystem()->localFileName($this->absolutePath));
    }

    /**
     * Tests whether the file denoted by this abstract pathname is a normal file.
     * 
     * @return boolean
     */
    public function isFile() {
        return FileSystem::getFileSystem()->isFile($this->absolutePath);
    }

    /**
     * Tests whether the file denoted by this abstract pathname is a directory.
     * 
     * @return boolean <b>TRUE</b> if the filename exists and is a directory, <b>FALSE</b> otherwise.
     */
    public function isDirectory() {
        return FileSystem::getFileSystem()->isDirectory($this->absolutePath);
    }

    /**
     * Creates the directory named by this abstract pathname.
     * 
     * @return boolean
     */
    public function mkdir() {
        return \mkdir(FileSystem::getFileSystem()->localFileName($this->absolutePath), 0755);
    }

    /**
     * Creates the directory named by this abstract pathname, including any necessary 
     * but nonexistent parent directories.
     * 
     * @return boolean
     */
    public function mkdirs() {
        return \mkdir(FileSystem::getFileSystem()->localFileName($this->absolutePath), 0755, TRUE);
    }

    /**
     * Returns the pathname string of this abstract pathname's parent, 
     * or <code>null</code> if this pathname does not name a parent directory. 
     * The <code>parent</code> of an abstract pathname consists of the pathname's prefix, 
     * if any, and each name in the pathname's name sequence except for the last.
     * If the name sequence is empty then the pathname does not name a parent directory.
     * 
     * @return string The pathname string of the parent directory, 
     *                 or <code>null</code> if this pathname does not name a parent.
     */
    public function getParent() {
        return FileSystem::getFileSystem()->normalize($this->path . "/..");
    }

    /**
     * Returns the abstract pathname of this abstract pathname's parent, 
     * or <code>null</code> if this pathname does not name a parent directory.
     * The <code>parent</code> of an abstract pathname consists of the pathname's prefix, 
     * if any, and each name in the pathname's name sequence except for the last. 
     * If the name sequence is empty then the pathname does not name a parent directory.
     * 
     * @return File The abstract pathname of the parent directory 
     *                   named by this abstract pathname, or <code>null</code> 
     *                   if this pathname does not name a parent.
     */
    public function getParentFile() {
        $p = $this->getParent();
        if (\is_null($p)) {
            return NULL;
        }
        return new File($p);
    }

}
