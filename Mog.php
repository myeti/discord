<?php

namespace Discord\Http;

abstract class Mog
{

    /** @var Request */
    protected static $request;


    /**
     * Request instance
     *
     * @param Request $request
     * @return Request
     */
    public static function request(Request $request = null)
    {
        if($request) {
            static::$request = $request;
        }
        if(!static::$request) {
            static::$request = Request::globals();
        }

        return static::$request;
    }


    /**
     * Get url
     *
     * @return Request\Url
     */
    public static function url()
    {
        return static::request()->url;
    }


    /**
     * Get http code
     *
     * @return int
     */
    public static function code()
    {
        return static::request()->code;
    }


    /**
     * Get http method
     *
     * @return string
     */
    public static function method()
    {
        return static::request()->method;
    }


    /**
     * Is https
     *
     * @return bool
     */
    public static function secure()
    {
        return static::request()->secure;
    }


    /**
     * Get http body
     *
     * @return string
     */
    public static function body()
    {
        return static::request()->body;
    }


    /**
     * Is ajax request
     *
     * @return bool
     */
    public static function ajax()
    {
        return static::request()->ajax;
    }


    /**
     * Get accept header
     *
     * @return Request\Accept
     */
    public static function accept()
    {
        return static::request()->accept;
    }


    /**
     * Get request resource
     *
     * @return callable|Request\Resource
     */
    public static function resource()
    {
        return static::request()->resource;
    }


    /**
     * Generate path
     *
     * @param string $path
     * @return string
     */
    public static function path(...$path)
    {
        if($path) {
            return static::request()->path(...$path);
        }

        return static::request()->path;
    }


    /**
     * Get header
     *
     * @param string $name
     * @return array|string
     */
    public static function header($name = null)
    {
        if($name) {
            return static::request()->header($name);
        }

        return static::request()->header;
    }


    /**
     * Get server
     *
     * @param string $name
     * @return array|string
     */
    public static function server($name = null)
    {
        if($name) {
            return static::request()->server($name);
        }

        return static::request()->server;
    }


    /**
     * Get env
     *
     * @param string $name
     * @return array|string
     */
    public static function env($name = null)
    {
        if($name) {
            return static::request()->env($name);
        }

        return static::request()->env;
    }


    /**
     * Get values
     *
     * @return array
     */
    public static function values()
    {
        return static::request()->values;
    }


    /**
     * Get value
     *
     * @param string $name
     * @return string
     */
    public static function value($name)
    {
        return static::request()->value($name);
    }


    /**
     * Get params
     *
     * @return array
     */
    public static function params()
    {
        return static::request()->params;
    }


    /**
     * Get param
     * @param string $name
     * @return string
     */
    public static function param($name)
    {
        return static::request()->param($name);
    }


    /**
     * Get cookies
     *
     * @return array
     */
    public static function cookies()
    {
        return static::request()->cookies;
    }


    /**
     * Get cookie
     *
     * @param string $name
     * @return string
     */
    public static function cookie($name)
    {
        return static::request()->cookie($name);
    }


    /**
     * Get files
     *
     * @return Request\File[]
     */
    public static function files()
    {
        return static::request()->files;
    }


    /**
     * Get file
     *
     * @param string $name
     * @return Request\File
     */
    public static function file($name)
    {
        return static::request()->file($name);
    }


    /**
     * Get user agent
     *
     * @return string
     */
    public static function agent()
    {
        return static::request()->agent;
    }


    /**
     * Get user ip
     *
     * @return string
     */
    public static function ip()
    {
        return static::request()->ip;
    }


    /**
     * Get request time
     *
     * @return string
     */
    public static function time()
    {
        return static::request()->time;
    }


    /**
     * Set custom data
     *
     * @param string $name
     * @param mixed $value
     */
    public static function set($name, $value)
    {
        static::request()->set($name, $value);
    }


    /**
     * Get custom data
     *
     * @param string $name
     *
     * @return mixed
     */
    public function get($name)
    {
        return static::request()->get($name);
    }


} 