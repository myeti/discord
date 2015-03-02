<?php

namespace Discord\Http;

class Client implements Handler
{

    /** @var string|Handler */
    protected $base;

    /** @var array */
    protected $header = [];


    /**
     * Setup client with default shared config
     *
     * @param string|Handler $base
     * @param array $header
     */
    public function __construct($base = null, array $header = [])
    {
        $this->base = $base;
        $this->header = $header;
    }


    /**
     * GET request
     *
     * @param string $url
     * @param array $header
     *
     * @return mixed
     */
    public function options($url, array $header = [])
    {
        $request = $this->request('OPTIONS', $url, [], $header);

        return $this->handle($request);
    }


    /**
     * GET request
     *
     * @param string $url
     * @param array $header
     *
     * @return mixed
     */
    public function get($url, array $header = [])
    {
        $request = $this->request('GET', $url, [], $header);

        return $this->handle($request);
    }


    /**
     * GET request
     *
     * @param string $url
     * @param array $header
     *
     * @return mixed
     */
    public function head($url, array $header = [])
    {
        $request = $this->request('HEAD', $url, [], $header);

        return $this->handle($request);
    }


    /**
     * POST request
     *
     * @param string $url
     * @param array $data
     * @param array $header
     *
     * @return mixed
     */
    public function post($url, array $data = [], array $header = [])
    {
        $request = $this->request('POST', $url, $data, $header);

        return $this->handle($request);
    }


    /**
     * PUT request
     *
     * @param string $url
     * @param array $data
     * @param array $header
     *
     * @return mixed
     */
    public function put($url, array $data = [], array $header = [])
    {
        $request = $this->request('PUT', $url, $data, $header);

        return $this->handle($request);
    }


    /**
     * GET request
     *
     * @param string $url
     * @param array $header
     *
     * @return mixed
     */
    public function delete($url, array $header = [])
    {
        $request = $this->request('DELETE', $url, [], $header);

        return $this->handle($request);
    }


    /**
     * Create request
     *
     * @param string $method
     * @param string $url
     * @param array $data
     * @param array $header
     *
     * @return Request
     */
    public function request($method, $url, array $data = [], array $header = [])
    {
        // clean url and header
        if(is_string($this->base)) {
            $url = $this->base . $url;
        }
        $header = array_merge($this->header, $header);


        // create request
        $request = new Request($url, strtoupper($method));
        $request->header = $header;
        if($data) {
            $request->body = $data;
        }

        return $request;
    }


    /**
     * Handle request to create response
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        // delegated handler
        if($this->base instanceof Handler) {
            return $this->base->handle($request);
        }

        // create curl
        $curl = new Curl($request->url->absolute());
        $curl->opt(CURLOPT_HTTPHEADER, $request->header);

        // specific methods
        switch($request->method) {
            case 'GET':
                $curl->opt(CURLOPT_HTTPGET, true);
                break;
            case 'POST':
                $curl->opt(CURLOPT_POST, true);
                $curl->opt(CURLOPT_POSTFIELDS, $request->body);
                break;
            case 'PUT':
                $curl->opt(CURLOPT_PUT, true);
                $curl->opt(CURLOPT_POSTFIELDS, $request->body);
                break;
            case 'HEAD':
                $curl->opt(CURLOPT_CUSTOMREQUEST, 'head');
                $curl->opt(CURLOPT_NOBODY, true);
                break;
            default:
                $curl->opt(CURLOPT_CUSTOMREQUEST, strtolower($request->method));
        }

        // execute curl
        $content = $curl->send();
        $status = $curl->info(CURLINFO_HTTP_CODE);
        $header = $curl->info(CURLINFO_HEADER_OUT);

        // create response
        $response = new Response($content, $status, $header);

        return $response;
    }
}