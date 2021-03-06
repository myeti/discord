<?php

/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Box\Lipsum;

interface Source
{

    /**
     * Generate random text
     * @param int $words
     * @param int $lines
     * @param int $texts
     * @return string
     */
    public function generate($words, $lines, $texts);

} 