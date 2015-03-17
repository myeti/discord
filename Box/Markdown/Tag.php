<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Box\Markdown;

use Discord\Box\Markdown;

abstract class Tag
{

    /** @var Markdown */
    protected $md;

    /**
     * Hard reference to md
     * @param Markdown $md
     */
    public function __construct(Markdown &$md)
    {
        $this->md = $md;
    }

    /**
     * Transform md to html tag
     * @param string $text
     * @return string
     */
    abstract public function transform($text);

} 