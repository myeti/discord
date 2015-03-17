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
 * Is email
 * @param $string
 * @return mixed
 */
function is_email($string)
{
    return filter_var($string, FILTER_VALIDATE_EMAIL);
}


/**
 * Is url
 * @param $string
 * @return mixed
 */
function is_url($string)
{
    return filter_var($string, FILTER_VALIDATE_URL);
}


/**
 * Is ip address
 * @param $string
 * @return mixed
 */
function is_ip($string)
{
    return filter_var($string, FILTER_VALIDATE_IP);
}


/**
 * Is regex
 * @param $string
 * @return mixed
 */
function is_regex($string)
{
    return filter_var($string, FILTER_VALIDATE_REGEXP);
}


/**
 * Check range
 * @param $int
 * @param $min
 * @param $max
 * @return bool
 */
function is_between($int, $min, $max)
{
    return filter_var($int, FILTER_VALIDATE_INT, [
        'options' => [
            'min_range' => $min,
            'max_range' => $max,
        ]
    ]);
}