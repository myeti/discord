<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Persist\Session;

class Native implements Provider
{

    /** @var string */
    protected $name;

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

        // link to global session
        if($name) {
            $this->name = $name;
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
        return array_dot_has($this->data, $key);
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
        if($this->has($key)) {

            // get stored value
            $value = array_dot_get($this->data, $key);

            // unserialize non-scalar value
            $unserialized = @unserialize($value);
            if($value === 'b:o;' or $unserialized !== false) {
                $value = $unserialized;
            }

            return $value;
        }
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
        // serialize non-scalar value
        if(!is_scalar($value)) {
            $value = serialize($value);
        }

        array_dot_set($this->data, $key, $value);

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
            array_dot_drop($this->data, $key);
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