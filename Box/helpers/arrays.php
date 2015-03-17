<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */


/**
 * Check if input is traversable
 *
 * @param $input
 *
 * @return bool
 */
function is_traversable($input)
{
    return (is_array($input) || $input instanceof \Traversable);
}


/**
 * Check if input is a collection
 *
 * @param $input
 *
 * @return bool
 */
function is_collection($input)
{
    return (is_array($input) || $input instanceof \ArrayAccess);
}


/**
 * Check if key exists
 *
 * @param array $array
 * @param string $key
 *
 * @return bool
 */
function array_has(array $array, $key)
{
    return isset($array[$key]);
}


/**
 * Silent get
 *
 * @param array $array
 * @param string $key
 *
 * @return null|mixed
 */
function array_get(array $array, $key)
{
    return isset($array[$key]) ? $array[$key] : null;
}


/**
 * Get first element
 *
 * @param array $array
 *
 * @return mixed
 */
function array_first(array $array)
{
    return reset($array);
}


/**
 * Get first key
 *
 * @param array $array
 *
 * @return string
 */
function array_first_key(array $array)
{
    reset($array);
    return key($array);
}


/**
 * Get last element
 *
 * @param array $array
 *
 * @return mixed
 */
function array_last(array $array)
{
    return end($array);
}


/**
 * Get last key
 *
 * @param array $array
 *
 * @return string
 */
function array_last_key(array $array)
{
    end($array);
    return key($array);
}


/**
 * Find first key of matched value
 *
 * @param array $array
 * @param mixed $value
 *
 * @return int
 */
function array_key(array $array, $value)
{
    return array_search($value, $array);
}


/**
 * Filter only string keys
 *
 * @param array $array
 *
 * @return array
 */
function array_string_keys(array $array)
{
    foreach($array as $key => $value) {
        if(is_int($key)) {
            unset($array[$key]);
        }
    }

    return $array;
}


/**
 * Replace all value
 *
 * @param array $array
 * @param mixed $value
 * @param mixed $replacement
 *
 * @return array
 */
function array_replace_value(array $array, $value, $replacement)
{
    $keys = array_keys($array, $value);
    foreach($keys as $key) {
        $array[$key] = $replacement;
    }

    return $array;
}


/**
 * Replace key and keep order
 *
 * @param array $array
 * @param mixed $key
 * @param mixed $replacement
 *
 * @return array|bool
 */
function array_replace_key(array $array, $key, $replacement)
{
    // key does not exists
    if(!isset($array[$key])) {
        return false;
    }

    // search current key
    $keys = array_keys($array);
    $index = array_search($key, $keys);

    // replace
    $keys[$index] = $replacement;
    return array_combine($keys, $array);
}


/**
 * Remove rows with specified value
 *
 * @param array $array
 * @param mixed $value
 *
 * @return array
 */
function array_drop(array $array, $value)
{
    $keys = array_keys($array, $value);
    return array_diff_key($array, array_flip($keys));
}


/**
 * Insert element at specific position
 *
 * @param array $array
 * @param mixed $value
 * @param string $at
 *
 * @return array
 */
function array_insert(array $array, $value, $at)
{
    $before = array_slice($array, 0, $at);
    $after = array_slice($array, $at);
    $before[] = $value;
    return array_merge($before, array_values($after));
}


/**
 * Filter keys
 *
 * @param array $array
 * @param callable $callback
 *
 * @return array
 */
function array_filter_key(array $array, callable $callback)
{
    $keys = array_map(array_keys($array), $callback);
    return array_diff_key($array, array_flip($keys));
}


/**
 * Get random element(s)
 *
 * @param array $array
 * @param int $num
 *
 * @return mixed|array
 */
function array_random(array $array, $num = 1)
{
    $keys = (array)array_rand($array, $num);
    $results = array_intersect_key($array, $keys);

    return ($num == 1) ? current($results) : $results;
}


/**
 * Sort array by columns
 * - [column => SORT_ASC] let you decide
 * - [column1, column2] will sort ASC
 *
 * @param array $array
 * @param array $by
 *
 * @return array
 */
function array_sort(array $array, array $by)
{
    // resolve sorting
    $sort = [];
    foreach($by as $key => $val) {
        if(is_int($key)) {
            $sort[$val] = SORT_ASC;
        } else {
            $sort[$key] = $val;
        }
    }

    // prepare columns
    $columns = [];
    foreach($array as $key => $row) {
        foreach($row as $column => $value) {

            // need sorting ?
            if(isset($sort[$column])) {
                $columns[$column][$key] = $value;
            }

        }
    }

    // prepare args
    $args = [];
    foreach($columns as $name => $keys) {
        $args[] = $keys;
        $args[] = $sort[$name];
    }
    $args[] = $array;

    return array_multisort(...$args);
}


/**
 * Check is key exists in array
 *
 * @param array $array
 * @param string $key
 * @param string $separator
 *
 * @return bool
 */
function array_dot_has(array $array, $key, $separator = '.')
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
function array_dot_get(array $array, $key, $separator = '.')
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
function array_dot_pop(array $array, $key, $separator = '.')
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
function array_dot_set(array &$array, $key, $value, $separator = '.')
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
function array_dot_push(array &$array, $key, $value, $separator = '.')
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
function array_dot_drop(array &$array, $key, $separator = '.')
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