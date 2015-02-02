<?php

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