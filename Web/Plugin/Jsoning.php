<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Web\Plugin;

use Discord\Http;

class Jsoning
{

    /**
     * Handle response rendering
     *
     * @event kernel.respond
     *
     * @param Http\Request $request
     * @param $data
     *
     * @return Http\Response\Json
     */
    public function respond(Http\Request $request, $data)
    {
        return new Http\Response\Json($data);
    }

} 