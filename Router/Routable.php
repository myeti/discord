<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Router;

interface Routable
{

    /**
     * Find route from input
     *
     * @param string $from
     * @param array $rules
     *
     * @return mixed
     */
    public function find($from, array $rules = []);

}