<?php
namespace JayaCode\Framework\Core\Http;

use JayaCode\Framework\Core\Session\Session;
use Symfony\Component\HttpFoundation\Request as BaseRequest;

/**
 * Class Request
 * @package JayaCode\Framework\Core\Http
 */
class Request extends BaseRequest
{
    /**
     * @var Session
     */
    protected $session;

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
     * Creates a new request with values from PHP's super globals.
     *
     * @param Session $session
     * @return Request A new request
     */
    public static function createFromSymfonyGlobal(Session $session)
    {
        $baseRequest = BaseRequest::createFromGlobals();

        $query = $baseRequest->query->all();
        $request = $baseRequest->request->all();
        $attributes = array();
        $cookies = $baseRequest->cookies->all();
        $files = $baseRequest->files->all();
        $server = $baseRequest->server->all();
        $content = $baseRequest->getContent();

        $req = new static($query, $request, $attributes, $cookies, $files, $server, $content);
        $req->setSession($session);

        return $req;
    }

    /**
     * Gets the Session.
     *
     * @return Session|null The session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasPost($name)
    {
        return $this->request->has($name);
    }

    /**
     * @param null $name
     * @param null $default
     * @return array|mixed|null
     */
    public function post($name = null, $default = null)
    {
        return is_null($name)?$this->request->all():$this->request->get($name, $default);
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasOldPost($name)
    {
        return $this->session->hasFlash("old.post.{$name}");
    }

    /**
     * @param null $name
     * @param null $default
     * @return array
     */
    public function oldPost($name = null, $default = null)
    {
        return $this->getOldByFullName("old.post.{$name}", $default);
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasQuery($name)
    {
        return $this->query->has($name);
    }

    /**
     * @param null $name
     * @param null $default
     * @return array|mixed|null
     */
    public function query($name = null, $default = null)
    {
        return is_null($name)?$this->query->all():$this->query->get($name, $default);
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasOldQuery($name)
    {
        return $this->session->hasFlash("old.query.{$name}");
    }

    /**
     * @param null $name
     * @param null $default
     * @return array
     */
    public function oldQuery($name, $default = null)
    {
        return $this->getOldByFullName("old.query.{$name}", $default);
    }

    private function getOldByFullName($name, $default = null)
    {
        if (null !== $result = $this->session->getFlash($name)) {
            return $result;
        }

        return $default;
    }

    /**
     * @param $name
     * @param null $default
     * @return array|mixed|null
     */
    public function input($name, $default = null)
    {
        if (null !== $result = $this->query($name)) {
            return $result;
        }

        if (null !== $result = $this->post($name)) {
            return $result;
        }

        return $default;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasFiles($name)
    {
        return $this->files->has($name);
    }

    /**
     * @param null $name
     * @return array|mixed
     */
    public function files($name = null)
    {
        if (is_null($name)) {
            return $this->files->all();
        }
        return $this->files->get($name);
    }
}
