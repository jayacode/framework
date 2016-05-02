<?php
namespace JayaCode\Framework\Core\Http;

class Request extends \Symfony\Component\HttpFoundation\Request
{
    /**
     * Return IP address client
     * @return string
     */
    public function ip()
    {
        return $this->getClientIp();
    }

    /**
     * Return IP address client
     * @return array
     */
    public function ipAll()
    {
        return $this->getClientIps();
    }
}
