<?php

namespace Discord\Web;

use Discord\Http;

class Kernel implements Http\Handler
{

    /** @var Service[] */
    protected $services = [];


    /**
     * Construct with services
     *
     * @param Service ...$services
     */
    public function __construct(Service ...$services)
    {
        foreach($services as $service) {
            $this->plug($service);
        }
    }


    /**
     * Register service
     *
     * @param Service $service
     *
     * @return $this
     */
    public function plug(Service $service)
    {
        $this->services[] = $service;

        return $this;
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

            // execute <before> services
            foreach($this->services as $service) {
                $return = $service->before($request);
                if($return instanceof Http\Response) {
                    return $return;
                }
            }

            // check if resource is callable
            if(!$request->resource instanceof Http\Request\Resource) {
                throw new \RuntimeException('Request::resource must be a valid callable');
            }

            // execute resource
            $response = call_user_func($request->resource);
            if(!$response instanceof Http\Response) {
                $response = new Http\Response($response);
            }

        }
        catch(\Exception $e) {

            // execute <error> services
            foreach($this->services as $service) {
                $return = $service->error($request, $e);
                if($return instanceof Http\Response) {
                    return $return;
                }
            }

            // error not caught
            throw $e;
        }
        finally {

            // execute <after> services
            foreach($this->services as $service) {
                $return = $service->after($request, $response);
                if($return instanceof Http\Response) {
                    $response = $return;
                }
            }

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