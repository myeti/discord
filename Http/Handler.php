<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Http;

/**
 * Universal http request handler
 */
interface Handler
{

    /**
     * Handle request to create response
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request);

}