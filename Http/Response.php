<?php

namespace Discord\Http;

class Response
{

    /** @var int */
    public $code = 200;

    /** @var string */
    public $format = 'text/html';

    /** @var string */
    public $charset = 'utf-8';

    /** @var array */
    public $headers = [];

    /** @var string */
    public $content;

    /** @var array */
    public $data = [];

    /** @var array */
    protected static $codes = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',            // RFC2518
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',          // RFC4918
        208 => 'Already Reported',      // RFC5842
        226 => 'IM Used',               // RFC3229
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',    // RFC-reschke-http-status-308-07
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',                                               // RFC2324
        422 => 'Unprocessable Entity',                                        // RFC4918
        423 => 'Locked',                                                      // RFC4918
        424 => 'Failed Dependency',                                           // RFC4918
        425 => 'Reserved for WebDAV advanced collections expired proposal',   // RFC2817
        426 => 'Upgrade Required',                                            // RFC2817
        428 => 'Precondition Required',                                       // RFC6585
        429 => 'Too Many Requests',                                           // RFC6585
        431 => 'Request Header Fields Too Large',                             // RFC6585
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates (Experimental)',                      // RFC2295
        507 => 'Insufficient Storage',                                        // RFC4918
        508 => 'Loop Detected',                                               // RFC5842
        510 => 'Not Extended',                                                // RFC2774
        511 => 'Network Authentication Required',                             // RFC6585
    ];


    /**
     * New Response
     *
     * @param string $content
     * @param int $code
     * @param array $headers
     */
    public function __construct($content = null, $code = 200, array $headers = [])
    {
        $this->content = $content;
        $this->code = $code;

        foreach($headers as $header  =>  $value) {
            $this->header($header, $value);
        }
    }


    /**
     * Set header
     *
     * @param string $name
     * @param string $value
     * @param bool $replace
     *
     * @return $this
     */
    public function header($name, $value, $replace = true)
    {
        $name = strtolower($name);
        if(isset($this->headers[$name]) and !$replace) {
            if(is_array($this->headers[$name])) {
                array_push($this->headers[$name], $value);
            }
            else {
                $this->headers[$name] = [
                    $this->headers[$name],
                    $value
                ];
            }
        }
        else {
            $this->headers[$name] = $value;
        }

        return $this;
    }


    /**
     * Set cookie
     *
     * @param string $name
     * @param string $value
     * @param int $expires
     *
     * @return $this
     */
    public function cookie($name, $value, $expires = 0)
    {
        $cookie = urlencode($name);

        // has value
        if($value) {
            $cookie .= '=' . urlencode($value) . ';';
            $cookie .= ' expires=' . gmdate("D, d-M-Y H:i:s T", time() - 31536001) . ';';
        }
        // delete cookie
        else {
            $cookie .= '=deleted;';
            if($expires) {
                $cookie .= ' expires=' . gmdate("D, d-M-Y H:i:s T", time() - $expires);
            }
        }

        return $this->header('Set-Cookie', $cookie, false);
    }


    /**
     * Add no-cache headers
     *
     * @return $this
     */
    public function noCache()
    {
        $this->header('Cache-Control', 'no-cache, must-revalidate');
        $this->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');

        return $this;
    }


    /**
     * Response already sent ?
     *
     * @return bool
     */
    public function sent()
    {
        return headers_sent();
    }


    /**
     * Send response
     *
     * @return string
     */
    public function send()
    {
        // send headers
        if(!$this->sent()) {

            // set content type
            if(!isset($this->headers['Content-Type'])) {
                $header = 'Content-Type: ' . $this->format;
                if($this->charset) {
                    $header .= '; charset=' . $this->charset;
                }
                header($header);
            }

            // set http code
            if(!isset(static::$codes[$this->code])) {
                $this->code = 200;
            }
            header('HTTP/1.1 ' . $this->code . ' ' . static::$codes[$this->code], true, $this->code);

            // compile header
            foreach($this->headers as $name => $value) {
                if(is_array($value)) {
                    foreach($value as $subvalue) {
                        header($name . ': ' . $subvalue);
                    }
                }
                else {
                    header($name . ': ' . $value);
                }
            }
        }

        // send content
        echo (string)$this->content;

        return $this->sent();
    }

}