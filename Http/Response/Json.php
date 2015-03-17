<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Http\Response;

use Discord\Http\Response;

class Json extends Response
{

    /**
     * New JSON Response
     *
     * @param string $content
     * @param int $code
     * @param array $headers
     */
    public function __construct($content = null, $code = 200, array $headers = [])
    {
        parent::__construct(json_encode($content, JSON_PRETTY_PRINT), $code, $headers);
        $this->format = 'application/json';
    }

} 