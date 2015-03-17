<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */


const STR_LEFT = 0;
const STR_RIGHT = 1;
const STR_BOTH = 2;
const STR_ANYWHERE = 4;


/**
 * Add ellipsis to string's end
 *
 * @param string $string
 * @param int $length
 *
 * @return string
 */
function str_ellipsis($string, $length)
{
    if($length > 3) {
        $length-= 3;
    }

    return substr($string, $length) . '...';
}


/**
 * Check if segment exists in string
 *
 * @param $string
 * @param $segment
 * @param int $where
 *
 * @return bool
 */
function str_has($string, $segment, $where = STR_ANYWHERE)
{
    if($where === STR_LEFT) {
        return strncasecmp($string, $segment, strlen($segment)) === 0;
    }
    elseif($where === STR_RIGHT) {
        return substr_compare($string, $segment, -strlen($segment)) === 0;
    }

    return strpos($string, $segment) !== false;
}


/**
 * Remove segment in string
 *
 * @param string $string
 * @param string $segment
 *
 * @return string
 */
function str_remove($string, $segment)
{
    return str_replace($segment, null, $string);
}


/**
 * Ensure that segment exists in string
 *
 * @param string $string
 * @param string $segment
 * @param int $where
 *
 * @return string
 */
function str_ensure($string, $segment, $where = STR_RIGHT)
{
    if(!str_has($string, $segment, $where)) {
        $string = ($where === STR_LEFT)
            ? $segment . $string
            : $string . $segment;
    }

    return $string;
}


/**
 * Compose string using :vars
 *
 * @param string $string
 * @param array $placeholders
 *
 * @return string
 */
function str_compose($string, array $placeholders = [])
{
    foreach($placeholders as $placeholder => $value) {
        $string = str_replace(':' . $placeholder, $value, $string);
    }

    return $string;
}


/**
 * Extract :vars from string
 *
 * @param string $string
 * @param string $mask
 * @return string
 */
function str_mask($string, $mask)
{
    $pattern = '/^' . preg_replace('/:([\w]+)/', '(?<$1>.+)', $mask) . '$/';
    return regex_match($string, $pattern);
}


/**
 * Escape string
 *
 * @param string $string
 *
 * @return string
 */
function str_escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}


/**
 * String matching using wildcard *
 *
 * @param string $string
 * @param string $comparison
 *
 * return bool
 */
function str_is($string, $comparison)
{
    $pattern = preg_quote($comparison);
    $pattern = str_replace('\\*', '.*', $pattern);
    $pattern = '/^' . $pattern . '$/';

    return (bool)preg_match($pattern, $string);
}


/**
 * Check if serialized string
 *
 * @param $string
 *
 * @return bool
 */
function str_is_serialized($string)
{
    if($string == 'b:0;') {
        return true;
    }

    return (@unserialize($string) !== false);
}


/**
 * Regex match and get string keys
 *
 * @param $string
 * @param $pattern
 * @param bool $string_keys
 *
 * @return array|bool
 */
function regex_match($string, $pattern)
{
    if(preg_match($pattern, $string, $matches)) {
        return array_string_keys($matches);
    }

    return false;
}


/**
 * Regex replace
 *
 * @param string $string
 * @param string $pattern
 * @param mixed $replacement
 *
 * @return string
 */
function regex_replace($string, $pattern, $replacement)
{
    return ($replacement instanceof \Closure)
        ? preg_replace_callback($pattern, $replacement, $string)
        : preg_replace($pattern, $replacement, $string);
}