<?php

namespace Discord\Persist\Session;

use Discord\Persist\Session;

class Native implements Session\Provider
{

    /** @var array */
    protected $data = [];


    /**
     * Start session
     *
     * @param string $name
     */
    public function __construct($name = null)
    {
        // config
        if(!session_id() and !headers_sent()) {
            ini_set('session.use_trans_sid', 0);
            ini_set('session.use_only_cookies', 1);
            ini_set("session.cookie_lifetime", 604800);
            ini_set("session.gc_maxlifetime", 604800);
            session_set_cookie_params(604800);
            session_start();
        }

        // link to php session
        if($name) {
            if(!isset($_SESSION[$name])) {
                $_SESSION[$name] = [];
            }
            $this->data = &$_SESSION[$name];
        }
        else {
            $this->data = &$_SESSION;
        }
    }


    /**
     * Check value in session
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return isset($this->data[$key]);
    }


    /**
     * Read value in session
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }


    /**
     * Write value in session
     *
     * @param string $key
     * @param $value
     *
     * @return $this
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }


    /**
     * Remove value from session
     *
     * @param $key
     *
     * @return $this
     */
    public function drop($key)
    {
        if($this->has($key)) {
            unset($this->data[$key]);
        }

        return $this;
    }


    /**
     * Wipe all values
     *
     * @return $this
     */
    public function wipe()
    {
        $this->data = [];

        return $this;
    }

}