<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the Licence.txt
 * file that was distributed with this source code.
 */
namespace Discord\Storage;

class File
{

    /** @var string */
    public $file;

    /** @var string */
    public $path;

    /** @var string */
    public $name;

    /** @var string */
    public $ext;

    /** @var int */
    public $size;

    /** @var string */
    public $mime;

    /** @var string */
    public $date;


    /**
     * Open file
     *
     * @param string $file
     */
    public function __construct($file)
    {
        $this->refresh($file);
    }


    /**
     * Move file to another destination
     *
     * @param string $to
     *
     * @return bool
     */
    public function move($to)
    {
        $file = rtrim($to, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $this->name;
        $moved = rename($this->file, $file);

        $this->refresh($file);

        return $moved;
    }


    /**
     * Rename file
     *
     * @param string $name
     *
     * @return bool
     */
    public function rename($name)
    {
        $file = $this->path . trim($name, DIRECTORY_SEPARATOR);
        $renamed = rename($this->file, $file);

        $this->refresh($file);

        return $renamed;
    }


    /**
     * Copy file to path
     *
     * @param string $to
     * @param string $name
     *
     * @return static|false
     */
    public function copy($to, $name = null)
    {
        $file = rtrim($to, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . ($name ?: $this->name);
        if(copy($this->file, $file)) {
            return new static($file);
        }

        return false;
    }


    /**
     * Rename file
     *
     * @return $this
     */
    public function delete()
    {
        return unlink($this->file);
    }


    /**
     * Read file content
     *
     * @return string
     */
    public function read()
    {
        return file_get_contents($this->file);
    }


    /**
     * Write file content
     *
     * @param string $content
     * @param bool $append
     *
     * @return bool
     */
    public function write($content, $append = false)
    {
        $flag = $append ? FILE_APPEND : 0;
        return file_put_contents($this->file, $content, $flag);
    }


    /**
     * Get current folder
     *
     * @return Folder
     */
    public function folder()
    {
        return new Folder($this->path);
    }


    /**
     * Create file
     *
     * @param string $file
     *
     * @return static
     */
    public static function create($file)
    {
        if(static::exists($file) or file_put_contents($file, null)) {
            return new static($file);
        }

        return false;
    }


    /**
     * Check if file exists
     *
     * @param string $file
     *
     * @return bool
     */
    public static function exists($file)
    {
        return file_exists($file);
    }


    /**
     * Extract data from file
     *
     * @param $file
     */
    protected function refresh($file)
    {
        $file = realpath($file);
        $this->file = $file;

        $this->path = basename($file, PATHINFO_DIRNAME);
        $this->name = basename($file, PATHINFO_BASENAME);
        $this->ext = basename($file, PATHINFO_EXTENSION);

        $this->size = filesize($file);
        $this->mime = mime_content_type($file);
        $this->date = filemtime($file);
    }

} 