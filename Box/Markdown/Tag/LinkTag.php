<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Box\Markdown\Tag;

use Discord\Box\Markdown\Tag;

class LinkTag extends Tag
{

    /**
     * Transform md to html tag
     * @param string $text
     * @return string
     */
    public function transform($text)
    {
        $text = preg_replace('/([^!])\[(.+)\]\((.+) "(.+)"\)/', '$1<a href="$3" title="$4">$2</a>', $text);
        return preg_replace('/([^!])\[(.+)\]\((.+)\)/', '$1<a href="$3">$2</a>', $text);
    }

}