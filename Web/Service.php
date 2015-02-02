<?php

namespace Discord\Web;

use Discord\Http;

abstract class Service
{

    /**
     * Handle request resolution
     *
     * @param Http\Request $request
     *
     * @return Http\Response|null
     */
    public function before(Http\Request $request) {}


    /**
     * Handle response rendering
     *
     * @param Http\Request $request
     * @param Http\Response $response
     *
     * @return Http\Response|null
     */
    public function after(Http\Request $request, Http\Response $response) {}


    /**
     * Handle http error
     *
     * @param Http\Request $request
     * @param \Exception $e
     *
     * @return Http\Response|null
     */
    public function error(Http\Request $request, \Exception $e) {}

}