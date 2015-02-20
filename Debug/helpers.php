<?php

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