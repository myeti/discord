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

class Redirect extends Response
{

    /**
     * New Redirect Response
     *
     * @param string $url
     * @param int $code
     * @param array $headers
     */
    public function __construct($url, $code = 302, array $headers = [])
    {
        parent::__construct(null, $code, $headers);

        $this->header('Location', $url);
    }

} 