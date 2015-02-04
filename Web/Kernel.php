<?php

namespace Discord\Web;

use Discord\Http;
use Discord\Event;

class Kernel extends Event\Channel implements Http\Handler
{

    /**
     * Construct with services
     *
     * @param object ...$services
     */
    public function __construct(...$services)
    {
        // define event expectation
        $this->expect('kernel.request', Http\Response::class);
        $this->expect('kernel.error', Http\Response::class);
        $this->expect('kernel.response', Http\Response::class, true);

        // attach services
        foreach($services as $service) {
            $this->attach($service);
        }
    }


    /**
     * Handle request to create response
     *
     * @param Http\Request $request
     *
     * @return Http\Response
     * @throws \Exception
     */
    public function handle(Http\Request $request)
    {
        $response = null;
        try {

            // fire <kernel.request> event
            $return = $this->fire('kernel.request', $request);
            if($return instanceof Http\Response) {
                return $return;
            }

            // check if resource is callable
            if(!$request->resource instanceof Http\Request\Resource) {
                throw new \RuntimeException('Request::resource must be a valid callable');
            }

            // execute resource
            $data = call_user_func($request->resource);
            if(!$data instanceof Http\Response) {
                $response = new Http\Response;
                $response->data = $data;
            }
            else {
                $response = $data;
            }

        }
        catch(\Exception $e) {

            // fire <kernel.error> event
            $return = $this->fire('kernel.error', $request, $e);
            if($return instanceof Http\Response) {
                return $return;
            }

            // error not caught
            throw $e;
        }
        finally {

            // fire <kernel.response> event
            $response = $this->fire('kernel.response', $request, $response);

            // check if the response is valid
            if(!$response instanceof Http\Response) {
                throw new \RuntimeException('Response must be a valid instance');
            }

            return $response;
        }
    }


    /**
     * Inject user url
     *
     * @param string $url
     *
     * @param string $method
     * @param Http\Request $from
     *
     * @return Http\Response
     * @throws \Exception
     */
    public function to($url, $method = 'GET', Http\Request $from = null)
    {
        if($from) {
            $request = $from;
            $request->url = new Http\Request\Url($url);
            $request->method = $method;
        }
        else {
            $request = new Http\Request($url, $method);
        }

        return $this->handle($request);
    }


    /**
     * Inject user resource
     *
     * @param string $resource
     * @param Http\Request $from
     *
     * @return Http\Response
     * @throws \Exception
     */
    public function forward($resource, Http\Request $from = null)
    {
        $request = $from ?: new Http\Request(null);
        $request->resource = $resource;

        return $this->handle($request);
    }

}