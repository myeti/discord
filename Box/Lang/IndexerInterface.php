<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Box\Lang;

interface IndexerInterface
{

    /**
     * Load locale
     * @param $locale
     */
    public function locale($locale);

    /**
     * Translate message
     * @param string $text
     * @param array $vars
     * @return string
     */
    public function translate($text, array $vars = []);

    /**
     * Save current table
     */
    public function save();

} 