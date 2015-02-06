<?php

namespace Discord\Web\Service;

use Discord\Http;

class Jsoning
{

    /**
     * Handle response rendering
     *
     * @event kernel.response
     *
     * @param Http\Request $request
     * @param Http\Response $response
     *
     * @return Http\Response|null
     */
    public function kernelResponse(Http\Request $request, Http\Response $response)
    {
        // serialize to json format
        $json = json_encode($response->data, JSON_PRETTY_PRINT);
        $response->content = $json;
        $response->format = 'application/json';

        return $response;
    }

} 