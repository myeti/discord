<?php

namespace Discord\Web;

use Discord\Http;
use Discord\Event;

class Kernel extends Event\Channel implements Http\Handler
{

    /**
     * Construct a web kernel with service listeners
     *
     * @param object ...$services
     */
    public function __construct(...$services)
    {
        // attach services
        foreach($services as $service) {
            $this->attach($service);
        }

        // setup kernel
        $this->setup();
    }


    /**
     * Setup kernel
     *
     * Define event values expectation
     * and trigger 'kernel.setup' event.
     */
    protected function setup()
    {
        // define event expectation
        $this->expect('kernel.request', Http\Response::class);
        $this->expect('kernel.error', Http\Response::class);
        $this->expect('kernel.response', Http\Response::class, true);

        // delegated setup
        $this->fire('kernel.setup', $this);
    }


    /**
     * Handle request
     *
     * Resolve the request resource, trigger 'kernel.resolve' event.
     * Execute the resource, throw \RuntimeException is invalid callable.
     * Intercept error, trigger '{code}' event or 'kernel.error' event.
     * Respond by creating a response object, trigger 'kernel.respond' event.
     *
     * @param Http\Request $request
     *
     * @return Http\Response
     * @throws \Exception
     */
    public function handle(Http\Request $request)
    {
        $data = null;
        try {

            // resolve request
            $response = $this->resolve($request);
            if($response instanceof Http\Response) {
                return $this->finish($request, $response);
            }

            // invalid request
            if(!is_callable($request->resource)) {
                throw new Kernel\InvalidRequest;
            }

            // execute resource
            $data = call_user_func($request->resource);
            if($data instanceof Http\Response) {
                return $this->finish($request, $data);
            }
        }
        catch(\Exception $e) {

            // intercept error and dispatch as event
            $response = $this->intercept($request, $e);
            if($response instanceof Http\Response) {
                return $this->finish($request, $response);
            }
        }
        finally {

            // create response
            $response = $this->respond($request, $data);

            // invalid response
            if(!is_callable($request->resource)) {
                throw new Kernel\InvalidRequest;
            }

            return $this->finish($request, $response);
        }
    }


    /**
     * Resolve request
     *
     * Can return a response object, process halt.
     * If not, must set a valid callable resource.
     *
     * @param Http\Request $request
     *
     * @return Http\Response
     *
     * @throw \RuntimeException
     */
    protected function resolve(Http\Request $request)
    {
        // fire <kernel.resolve> event
        $response = $this->fire('kernel.resolve', $request);
        if($response instanceof Http\Response) {
            return $response;
        }

        // check if resource is a valid callable
        if(!is_callable($request->resource)) {
            throw new \RuntimeException('Request::resource must be a valid callable');
        }
    }


    /**
     * Intercept error
     *
     * First dispatch to the code event specified (ex: '404').
     * If not, dispatch to global 'kernel.error' event.
     *
     * Can return a response object : process halt.
     *
     * @param Http\Request $request
     * @param \Exception $e
     *
     * @return Http\Response
     *
     * @throws \Exception
     */
    protected function intercept(Http\Request $request, \Exception $e)
    {
        // fire <code> event
        if($code = $e->getCode()) {
            $this->expect($code, Http\Response::class);
            $response = $this->fire($code, $request);
            if($response instanceof Http\Response) {
                return $response;
            }
        }

        // fire <kernel.error> event
        $response = $this->fire('kernel.error', $request, $e);
        if($response instanceof Http\Response) {
            return $response;
        }

        // error not caught
        throw $e;
    }


    /**
     * Create response using data from resource
     *
     * Must return a valid response object, trigger 'kernel.respond' event
     *
     * @param Http\Request $request
     * @param $data
     *
     * @return Http\Response
     */
    protected function respond(Http\Request $request, $data)
    {
        // fire <kernel.respond> event
        $response = $this->fire('kernel.respond', $request, $data);

        // check if the response is valid
        if(!$response instanceof Http\Response) {
            throw new \RuntimeException('Response must be a valid instance');
        }

        return $response;
    }


    /**
     * Filter output response
     *
     * Nothing impacted.
     *
     * @param Http\Request $request
     * @param Http\Response $response
     *
     * @return Http\Response
     */
    protected function finish(Http\Request $request, Http\Response $response)
    {
        $this->fire('kernel.finish', $request, $response);

        return $response;
    }


    /**
     * Handle default request
     * and send response
     *
     * @return bool
     */
    public function run()
    {
        $request = Http\Request::globals();
        $response = $this->handle($request);

        return $response->send();
    }

}