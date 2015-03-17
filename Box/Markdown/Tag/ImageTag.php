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

class ImageTag extends Tag
{

    /**
     * Transform md to html tag
     * @param string $text
     * @return string
     */
    public function transform($text)
    {
        $text = preg_replace('/!\[(.+)\]\((.+) "(.+)"\)/', '<img src="$2" alt="$1" title="$3" />', $text);
        return preg_replace('/!\[(.+)\]\((.+)\)/', '<img src="$2" alt="$1" />', $text);
    }

}