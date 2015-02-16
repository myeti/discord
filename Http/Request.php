<?php

namespace Discord\Http;

class Request
{

    /** @var Request\Url */
    public $url;

    /** @var int */
    public $code = 200;

    /** @var string */
    public $method;

    /** @var bool */
    public $secure;

    /** @var string */
    public $body;

    /** @var bool */
    public $ajax;

    /** @var Request\Accept */
    public $accept;

    /** @var callable */
    public $resource;

    /** @var string */
    public $path;

    /** @var array */
    public $header = [];

    /** @var array */
    public $server = [];

    /** @var array */
    public $env = [];

    /** @var array */
    public $values = [];

    /** @var array */
    public $params = [];

    /** @var array */
    public $cookies = [];

    /** @var Request\File[] */
    public $files = [];

    /** @var string */
    public $agent;

    /** @var string */
    public $ip;

    /** @var string */
    public $time;

    /** @var array */
    protected $data = [];


    /**
     * New http request
     *
     * @param string|Request\Url $url
     * @param string $method
     */
    public function __construct($url, $method = 'GET')
    {
        $this->url = ($url instanceof Request\Url) ? $url : new Request\Url($url);
        $this->method = $method;

        $this->accept = new Request\Accept([], null, null, null);
    }


    /**
     * Get path from root
     *
     * @param string $path
     *
     * @return string
     */
    public function path(...$path)
    {
        $path = implode(DIRECTORY_SEPARATOR, $path);
        $path = ltrim($path, DIRECTORY_SEPARATOR);

        return $this->path . $path;
    }


    /**
     * Get header
     *
     * @param string $name
     *
     * @return string
     */
    public function header($name)
    {
        return isset($this->header[$name]) ? $this->header[$name] : null;
    }


    /**
     * Get _server
     *
     * @param string $name
     *
     * @return string
     */
    public function server($name)
    {
        return isset($this->server[$name]) ? $this->server[$name] : null;
    }


    /**
     * Get _env
     *
     * @param string $name
     *
     * @return string
     */
    public function env($name)
    {
        return isset($this->env[$name]) ? $this->env[$name] : null;
    }


    /**
     * Get _get
     *
     * @param string $name
     *
     * @return string
     */
    public function param($name)
    {
        return isset($this->params[$name]) ? $this->params[$name] : null;
    }


    /**
     * Get _post
     *
     * @param string $name
     *
     * @return string
     */
    public function value($name)
    {
        return isset($this->values[$name]) ? $this->values[$name] : null;
    }


    /**
     * Get _file
     *
     * @param string $name
     *
     * @return Request\File
     */
    public function file($name)
    {
        return isset($this->files[$name]) ? $this->files[$name] : null;
    }


    /**
     * Get _cookie
     *
     * @param string $name
     *
     * @return string
     */
    public function cookie($name)
    {
        return isset($this->cookies[$name]) ? $this->cookies[$name] : null;
    }


    /**
     * Set custom data
     *
     * @param string $name
     * @param mixed $value
     *
     * @return $this
     */
    public function set($name, $value)
    {
        $this->data[$name] = $value;

        return $this;
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
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }


    /**
     * Create from global environment
     *
     * @param int $urlStrategy
     *
     * @return static
     */
    public static function globals($urlStrategy = Request\Url::PATH_INFO)
    {
        $url = Request\Url::current($urlStrategy);

        $request = new static($url);
        $request->server = &$_SERVER;
        $request->env = &$_ENV;
        $request->values = &$_POST;
        $request->params = &$_GET;
        $request->cookies = &$_COOKIE;

        $request->code = @http_response_code();
        $request->accept = Request\Accept::from(
            $request->server('HTTP_ACCEPT'),
            $request->server('HTTP_ACCEPT_LANGUAGE'),
            $request->server('HTTP_ACCEPT_ENCODING'),
            $request->server('HTTP_ACCEPT_CHARSET')
        );
        $request->method = $request->server('REQUEST_METHOD');
        $request->body = @http_get_request_body();
        $request->secure = ($request->server('HTTPS') == 'on');
        $request->ajax = $request->server('HTTP_X_REQUESTED_WITH')
            && strtolower($request->server('HTTP_X_REQUESTED_WITH')) == 'xmlhttprequest';

        $request->path = dirname($request->server('SCRIPT_FILENAME'));
        $request->path = rtrim($request->path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        if(function_exists('apache_request_headers')) {
            $request->header = apache_request_headers();
        }

        foreach($_FILES as $index => $file) {
            $request->files[$index] = new Request\File($file);
        }

        $request->agent = $request->server('HTTP_USER_AGENT');
        $request->ip = $request->server('REMOTE_ADDR');
        $request->time = $request->server('REQUEST_TIME');

        return $request;
    }

}