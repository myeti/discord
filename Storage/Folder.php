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

class Folder
{

    /** @var string */
    public $folder;

    /** @var string */
    public $path;

    /** @var string */
    public $name;


    /**
     * Open folder
     *
     * @param string $folder
     */
    public function __construct($folder)
    {
        $this->refresh($folder);
    }


    /**
     * Move folder to another destination
     *
     * @param string $to
     *
     * @return bool
     */
    public function move($to)
    {
        $path = rtrim($to, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $this->name;
        $moved = rename($this->folder, $path);

        $this->refresh($path);

        return $moved;
    }


    /**
     * Rename folder
     *
     * @param string $name
     *
     * @return bool
     */
    public function rename($name)
    {
        $path = $this->path . ltrim($name, DIRECTORY_SEPARATOR);
        $renamed = rename($this->folder, $path);

        $this->refresh($path);

        return $renamed;
    }


    /**
     * Copy folder to path
     *
     * @param string $to
     * @param string $name
     *
     * @return static|false
     */
    public function copy($to, $name = null)
    {
        $path = $to . ($name ?: $this->name);
        $copied = mkdir($path);

        foreach($this->folders() as $folder) {
            $copied &= $folder->copy($path);
        }

        foreach($this->files() as $file) {
            $copied &= $file->copy($path);
        }

        if($copied) {
            return new static($path);
        }

        return false;
    }


    /**
     * Rename folder
     *
     * @return $this
     */
    public function delete()
    {
        foreach($this->folders() as $folder) {
            $folder->delete();
        }

        foreach($this->files() as $file) {
            $file->delete();
        }

        return rmdir($this->folder);
    }


    /**
     * Change path
     *
     * @param string $path
     *
     * @return static
     */
    public function in($path)
    {
        return new static($this->path . $path);
    }


    /**
     * Get parent folder
     *
     * @return static
     */
    public function parent()
    {
        return new static($this->path);
    }


    /**
     * Get all sub-folders
     *
     * @param string $search
     *
     * @return static[]
     */
    public function folders($search = null)
    {
        $pattern = $this->folder . '*';
        if($search) {
            $pattern .= $search . '*';
        }

        $folders = [];
        foreach(glob($pattern, GLOB_ONLYDIR) as $item) {
            $folders[] = new static($item);
        }

        return $folders;
    }


    /**
     * Get sub-folder
     *
     * @param string $name
     *
     * @return static
     */
    public function folder($name)
    {
        foreach($this->folders($name) as $folder) {
            if($folder->name == $name) {
                return $folder;
            }
        }

        return false;
    }


    /**
     * Get all sub-files
     *
     * @param string $search
     * @param bool $recursive
     *
     * @return File[]
     */
    public function files($search = null, $recursive = false)
    {
        $pattern = $this->folder . '*';
        if($search) {
            $pattern .= $search . '*';
        }

        $files = [];
        foreach(glob($pattern) as $item) {
            if(is_file($item)) {
                $files[] = new File($item);
            }
            elseif($recursive) {
                $children = $this->folder($item)->files($search, true);
                $files = array_merge($files, $children);
            }
        }

        return $files;
    }


    /**
     * Get file
     *
     * @param string $name
     *
     * @return File
     */
    public function file($name)
    {
        foreach($this->files($name) as $file) {
            if($file->name == $name) {
                return $file;
            }
        }

        return false;
    }


    /**
     * Compute global size
     *
     * @return int
     */
    public function size()
    {
        $size = 0;

        foreach($this->files() as $file) {
            $size += $file->size;
        }

        foreach($this->folders() as $folder) {
            $size += $folder->size();
        }

        return $size;
    }


    /**
     * Create folder
     *
     * @param string $folder
     *
     * @return static
     */
    public static function create($folder)
    {
        if(static::exists($folder) or mkdir($folder)) {
            return new static($folder);
        }

        return false;
    }


    /**
     * Check if folder exists
     *
     * @param string $folder
     *
     * @return bool
     */
    public static function exists($folder)
    {
        return is_dir($folder);
    }


    /**
     * Extract data from folder
     *
     * @param string $folder
     */
    protected function refresh($folder)
    {
        $folder = realpath($folder);
        $folder = rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->folder = $folder;

        $this->path = dirname($folder);
        $this->path = rtrim($this->path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        $this->name = basename($folder);
        $this->name = trim($this->name, DIRECTORY_SEPARATOR);
    }

} 