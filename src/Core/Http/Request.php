<?php
namespace JayaCode\Framework\Core\Http;

class Request extends \Symfony\Component\HttpFoundation\Request
{
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
    public function getRefererURL()
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
