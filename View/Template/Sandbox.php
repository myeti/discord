<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\View\Template;

use Discord\View\Viewable;

abstract class Sandbox
{
    /** @var Viewable */
    private $engine;

    /** @var string */
    private $template;

    /** @var string */
    private $layout;

    /** @var string */
    private $section;

    /** @var array */
    private $sections = [];

    /** @var array */
    private $helpers = [];

    /** @var bool */
    private $rendering = false;


    /**
     * Init template
     *
     * @param Viewable $engine
     * @param string $template
     * @param array $helpers
     *
     * @throws TemplateNotFound
     */
    public function __construct(Viewable $engine, $template, array $sections = [], array $helpers = [])
    {
        // error
        if(!file_exists($template)) {
            throw new TemplateNotFound('Template "' . $template . '" not found.');
        }

        $this->engine = $engine;
        $this->template = $template;
        $this->helpers = $helpers;
        $this->sections = $sections;
    }


    /**
     * Set layout
     *
     * @param string $template
     * @param array $vars
     *
     * @return string
     */
    protected function layout($template, array $vars = [])
    {
        $this->layout = [$template, $vars];
    }
    
    
    /**
     * Start recording section
     *
     * @param $name
     */
    protected function section($name)
    {
        $this->section = $name;
        ob_start();
    }


    /**
     * Stop recording section
     */
    protected function end()
    {
        $this->sections[$this->section] = ob_get_clean();
        $this->section = null;
    }


    /**
     * Insert section
     * @param $section
     * @return string
     */
    protected function insert($section)
    {
        return isset($this->sections[$section]) ? $this->sections[$section] : null;
    }


    /**
     * Insert child content
     * @return string
     */
    protected function content()
    {
        return $this->insert('__content__');
    }


    /**
     * Load partial
     *
     * @param string $template
     * @param array $vars
     * @param array $sections
     *
     * @return string
     */
    protected function load($template, array $vars = [], array $sections = [])
    {
        return $this->engine->render($template, $vars, $sections);
    }


    /**
     * Call helper
     *
     * @param string $helper
     * @param array $args
     * @throws \LogicException
     *
     * @return mixed
     */
    public function __call($helper, array $args = [])
    {
        if(!isset($this->helpers[$helper])) {
            throw new \LogicException('Unknown helper "' . $helper . '"');
        }

        return call_user_func_array($this->helpers[$helper], $args);
    }


    /**
     * Compile template
     *
     * @param array $vars
     *
     * @return string
     */
    public function compile(array $vars = [])
    {
        // start rendering
        if($this->rendering) {
            throw new \LogicException('Template is already rendering.');
        }
        $this->rendering = true;

        // start stream capture
        extract($vars);
        ob_start();

        // display file
        require $this->template;

        // stop stream capture
        $content = ob_get_clean();

        // render layout
        if($this->layout) {
            list($layout, $data) = $this->layout;
            $vars = array_merge($vars, $data);
            $sections = array_merge($this->sections, ['__content__' => $content]);
            $content = $this->engine->render($layout, $vars, $sections);
        }

        // end
        $this->rendering = false;
        return $content;
    }

}