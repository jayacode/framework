<?php
namespace JayaCode\Framework\Core\Http;

class Request extends \Symfony\Component\HttpFoundation\Request
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
}
