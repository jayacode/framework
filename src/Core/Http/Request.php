<?php
namespace JayaCode\Framework\Core\Http;

use Symfony\Component\HttpFoundation\Request as BaseRequest;

class Request extends BaseRequest
{

    /**
     * Get the current path info for the request.
     *
     * @return string
     */
    public function path()
    {
        $pattern = trim($this->getPathInfo(), '/');
        return $pattern == '' ? '/' : $pattern;
    }

    /**
     * Get the request method.
     *
     * @return string
     */
    public function method()
    {
        return $this->getMethod();
    }

    /**
     * Get the root URL
     *
     * @return string
     */
    public function rootURL()
    {
        return rtrim($this->getSchemeAndHttpHost().$this->getBaseUrl(), '/');
    }

    /**
     * Return true if server HTTP_REFERER isset
     *
     * @return bool
     */
    public function hasRefererURL()
    {
        return $this->server->has("HTTP_REFERER");
    }

    /**
     * Return server HTTP_REFERER
     *
     * @return string
     */
    public function refererURL()
    {
        return $this->server->get("HTTP_REFERER");
    }

    /**
     * Return IP address client
     *
     * @return string
     */
    public function ip()
    {
        return $this->getClientIp();
    }

    /**
     * Return IP address client
     *
     * @return array
     */
    public function ipAll()
    {
        return $this->getClientIps();
    }

    /**
     * Creates a new request with values from PHP's super globals.
     *
     * @return Request A new request
     */
    public static function createFromSymfonyGlobal()
    {
        $baseRequest = BaseRequest::createFromGlobals();

        $query = $baseRequest->query->all();
        $request = $baseRequest->request->all();
        $attributes = array();
        $cookies = $baseRequest->cookies->all();
        $files = $baseRequest->files->all();
        $server = $baseRequest->server->all();
        $content = $baseRequest->content->all();

        return new static($query, $request, $attributes, $cookies, $files, $server, $content);
    }
}
