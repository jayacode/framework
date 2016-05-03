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
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param null $content
     * @return array|mixed|static
     */
    private static function createRequestFromFactory(
        array $query = array(),
        array $request = array(),
        array $attributes = array(),
        array $cookies = array(),
        array $files = array(),
        array $server = array(),
        $content = null
    ) {
    
        if (self::$requestFactory) {
            $request = call_user_func(
                self::$requestFactory,
                $query,
                $request,
                $attributes,
                $cookies,
                $files,
                $server,
                $content
            );

            if (!$request instanceof self) {
                $message = 'The Request factory must return an instance of Symfony\Component\HttpFoundation\Request.';
                throw new \LogicException($message);
            }

            return $request;
        }

        return new static($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * Creates a new request with values from PHP's super globals.
     *
     * @return Request A new request
     */
    public static function createFromGlobals()
    {
        // With the php's bug #66606, the php's built-in web server
        // stores the Content-Type and Content-Length header values in
        // HTTP_CONTENT_TYPE and HTTP_CONTENT_LENGTH fields.
        $server = $_SERVER;
        if ('cli-server' === PHP_SAPI) {
            if (array_key_exists('HTTP_CONTENT_LENGTH', $_SERVER)) {
                $server['CONTENT_LENGTH'] = $_SERVER['HTTP_CONTENT_LENGTH'];
            }
            if (array_key_exists('HTTP_CONTENT_TYPE', $_SERVER)) {
                $server['CONTENT_TYPE'] = $_SERVER['HTTP_CONTENT_TYPE'];
            }
        }

        $request = self::createRequestFromFactory($_GET, $_POST, array(), $_COOKIE, $_FILES, $server);

        if (0 === strpos($request->headers->get('CONTENT_TYPE'), 'application/x-www-form-urlencoded')
            && in_array(strtoupper($request->server->get('REQUEST_METHOD', 'GET')), array('PUT', 'DELETE', 'PATCH'))
        ) {
            parse_str($request->getContent(), $data);
            $request->request = new ParameterBag($data);
        }

        return $request;
    }
}
