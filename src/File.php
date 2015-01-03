<?php

namespace Chigi\Component\IO;

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
     * @throws \InvalidArgumentException
     */
    function __construct($path, $parent_path = "") {
        if (is_null($path)) {
            throw new \InvalidArgumentException("The first path param must be not null.");
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
        return FileSystem::getFileSystem()->exists($this->absolutePath);
    }

    /**
     * Tests whether the file denoted by this abstract pathname is a normal file.
     * 
     * @return boolean
     */
    public function isFile() {
        return FileSystem::getFileSystem()->isFile($this->absolutePath);
    }

}
