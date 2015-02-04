<?php

namespace Discord\Http\Session;

interface Provider
{

    /**
     * Check value in session
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * Read value in session
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key);


    /**
     * Write value in session
     *
     * @param string $key
     * @param $value
     *
     * @return mixed
     */
    public function set($key, $value);


    /**
     * Write value in session once
     *
     * @param string $key
     * @param $value
     *
     * @return mixed
     */
    public function flash($key, $value);


    /**
     * Remove value from session
     * @param $key
     *
     * @return mixed
     */
    public function drop($key);


    /**
     * Wipe all values
     *
     * @return mixed
     */
    public function wipe();

}