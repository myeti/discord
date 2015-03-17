<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Http;

class Curl
{

    /** @var resource */
    protected $curl;


    /**
     * Setup curl
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->curl = curl_init($url);
        $this->opt(CURLOPT_URL, $url);
        $this->opt(CURLOPT_RETURNTRANSFER, true);
        $this->opt(CURLINFO_HEADER_OUT, true);
    }


    /**
     * Set option
     *
     * @param int $opt
     * @param mixed $value
     *
     * @return $this
     */
    public function opt($opt, $value)
    {
        curl_setopt($this->curl, $opt, $value);

        return $this;
    }


    /**
     * Magic set option
     *
     * @param string $opt
     * @param mixed $value
     *
     * @return $this
     */
    public function __call($opt, $value)
    {
        $opt = preg_replace('/[a-z]([A-Z])/', '_$1', $opt);
        $opt = 'CURL_' . strtoupper($opt);
        if(defined($opt)) {
            $this->opt($opt, $value);
        }

        return $this;
    }


    /**
     * Send request
     *
     * @return mixed
     */
    public function send()
    {
        return curl_exec($this->curl);
    }


    /**
     * Get curl info
     *
     * @param string $opt
     *
     * @return string
     */
    public function info($opt)
    {
        return curl_getinfo($this->curl, $opt);
    }


    /**
     * Close curl
     */
    public function __destruct()
    {
        if($this->curl) {
            curl_close($this->curl);
        }
    }

}