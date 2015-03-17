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
 * Debug vars
 *
 * @param $vars
 */
function debug(...$vars)
{
    if($vars) {
        var_dump(...$vars);
    }
    exit;
}


/**
 * Alias of debug()
 *
 * @param $vars
 */
function dd(...$vars)
{
    debug(...$vars);
}


/**
 * Log debug
 *
 * @param string $message
 */
function log_debug($message)
{
    Discord\Debug\Logger::debug($message);
}


/**
 * Log info
 *
 * @param string $message
 */
function log_info($message)
{
    Discord\Debug\Logger::info($message);
}


/**
 * Log notice
 *
 * @param string $message
 */
function log_notice($message)
{
    Discord\Debug\Logger::notice($message);
}


/**
 * Log error
 *
 * @param string $message
 */
function log_error($message)
{
    Discord\Debug\Logger::error($message);
}


/**
 * Log critical
 *
 * @param string $message
 */
function log_critical($message)
{
    Discord\Debug\Logger::critical($message);
}


/**
 * Log alert
 *
 * @param string $message
 */
function log_alert($message)
{
    Discord\Debug\Logger::alert($message);
}


/**
 * Log emergency
 *
 * @param string $message
 */
function log_emergency($message)
{
    Discord\Debug\Logger::emergency($message);
}