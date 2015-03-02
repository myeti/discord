<?php

namespace Discord\View;

class Engine implements Viewable
{

    /** @var string */
    public $directory;

    /** @var string */
    public $extension = '.php';

    /** @var array */
    protected $vars = [];

    /** @var array */
    protected $helpers = [];

    /** @var Engine[] */
    protected static $instances = [];


    /**
     * Setup engine
     *
     * @param string $directory
     * @param string $extension
     */
    public function __construct($directory, $extension = '.php')
    {
        // template directory
        $this->templates = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        // file extension
        $this->extension = $extension;
    }


    /**
     * Set global data
     *
     * @param string $var
     * @param mixed $value
     *
     * @return $this
     */
    public function set($var, $value)
    {
        $this->vars[$var] = $value;

        return $this;
    }


    /**
     * Set helper
     *
     * @param string $name
     * @param callable $helper
     *
     * @return $this
     */
    public function helper($name, callable $helper)
    {
        $this->helpers[$name] = $helper;

        return $this;
    }


    /**
     * Render template into viewable
     *
     * @param string $template
     * @param array $vars
     * @param array $sections
     *
     * @return mixed
     */
    public function render($template, array $vars = [], array $sections = [])
    {
        // define data
        $template = $this->templates . $template . $this->extension;
        $vars = array_merge($this->vars, $vars);

        // create template & compile
        $template = new Template($this, $template, $this->helpers);
        $content = $template->compile($vars, $sections);

        return $content;
    }


    /**
     * Static instance rendering
     *
     * @param string $template
     * @param array $data
     *
     * @return string
     */
    public static function make($template, array $data = [])
    {
        // parse path
        $dir = dirname($template);
        $filename = basename($template);

        // running engine on this directory ?
        if(!isset(static::$instances[$dir])) {
            static::$instances[$dir] = new self($dir);
        }

        // render
        return static::$instances[$dir]->render($filename, $data);
    }

}