<?php

namespace Discord\Box;

abstract class Dot
{

    /**
     * Check is key exists in array
     *
     * @param array $array
     * @param string $key
     * @param string $separator
     *
     * @return bool
     */
    public static function has(array $array, $key, $separator = '.')
    {
        $keys = explode($separator, $key);
        foreach($keys as $key) {
            if(!isset($array[$key])) {
                return false;
            }
            $array = $array[$key];
        }

        return true;
    }


    /**
     * Get value from array
     *
     * @param array $array
     * @param string $key
     * @param string $separator
     *
     * @return mixed
     */
    public static function get(array $array, $key, $separator = '.')
    {
        $keys = explode($separator, $key);
        foreach($keys as $key) {
            if(!isset($array[$key])) {
                return null;
            }
            $array = $array[$key];
        }

        return $array;
    }


    /**
     * Pop value from sub-array
     *
     * @param array $array
     * @param string $key
     * @param string $separator
     *
     * @return mixed
     */
    public static function pop(array $array, $key, $separator = '.')
    {
        $keys = explode($separator, $key);
        foreach($keys as $key) {
            if(!isset($array[$key])) {
                return null;
            }
            $array = $array[$key];
        }

        if(!is_array($array)) {
            return null;
        }

        return array_pop($array);
    }


    /**
     * Set value in array
     *
     * @param array $array
     * @param string $key
     * @param $value
     * @param string $separator
     */
    public static function set(array &$array, $key, $value, $separator = '.')
    {
        $keys = explode($separator, $key);
        foreach($keys as $key) {
            if(!isset($array[$key])) {
                $array[$key] = [];
            }
            $array = &$array[$key];
        }

        $array = $value;
    }


    /**
     * Push value in sub-array
     *
     * @param array $array
     * @param string $key
     * @param $value
     * @param string $separator
     */
    public static function push(array &$array, $key, $value, $separator = '.')
    {
        $keys = explode($separator, $key);
        foreach($keys as $key) {
            if(!isset($array[$key])) {
                $array[$key] = [];
            }
            $array = &$array[$key];
        }

        if(!is_array($array)) {
            $array = [];
        }

        array_push($array, $value);
    }


    /**
     * Delete key in array
     *
     * @param array $array
     * @param string $key
     * @param string $separator
     */
    public static function drop(array &$array, $key, $separator = '.')
    {
        $keys = explode($separator, $key);
        $last = array_pop($keys);
        foreach($keys as $key) {
            if(!isset($array[$key])) {
                return true;
            }
            $array = &$array[$key];
        }

        if(isset($array[$last])) {
            unset($array[$last]);
        }
    }

} 