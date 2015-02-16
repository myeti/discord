<?php

namespace Discord\View;

class Html extends Engine
{

    /** @var string */
    public $assets = '/';


    /**
     * Setup engine
     *
     * @param string $directory
     * @param string $assets
     */
    public function __construct($directory, $assets = '/')
    {
        parent::__construct($directory);

        // url for assets
        $this->assets = $assets;

        // text helper
        $this->helper('e', [$this, 'escape']);

        // assets helper
        $this->helper('asset', [$this, 'asset']);
        $this->helper('css', [$this, 'css']);
        $this->helper('js', [$this, 'js']);
    }


    /**
     * Escape output string
     *
     * @param string $string
     *
     * @return string
     */
    public function escape($string)
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }


    /**
     * Get asset path
     *
     * @param string $filename
     * @param string $ext
     *
     * @return string
     */
    public function asset($filename, $ext = null)
    {
        if($ext) {
            $ext = '.' . ltrim($ext, '.');
        }

        return $this->assets . '/' . ltrim($filename, '/') . $ext;
    }


    /**
     * Css tag
     *
     * @param $files
     *
     * @return string
     */
    public function css(...$files)
    {
        $css = [];
        foreach($files as $file) {
            $css[] = '<link type="text/css" href="' . $this->asset($file, '.css') . '" rel="stylesheet" />';
        }

        return implode("\n    ", $css) . "\n";
    }


    /**
     * Js tag
     *
     * @param $files
     *
     * @return string
     */
    public function js(...$files)
    {
        $js = [];
        foreach($files as $file) {
            $js[] = '<script type="text/javascript" src="' . $this->asset($file, '.js')  . '"></script>';
        }

        return implode("\n    ", $js) . "\n";
    }

}