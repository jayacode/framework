<?php
namespace JayaCode\Framework\Core\Session;

use Symfony\Component\HttpFoundation\Session\Session as SessionBase;

class Session extends SessionBase
{
    private $flash = array();
    private $flashNew = array();

    public function start()
    {
        $storage = $this->storage->start();

        $this->initFlash();
        return $storage;
    }

    public function initFlash()
    {
        $this->flash = $this->get("flash", array());
        $this->set("flash", array());
    }

    private function moveNewFlashToFlash()
    {
        $this->set("flash", $this->flashNew);
    }

    public function setFlash($name, $value)
    {
        $this->flashNew[$name] = $value;
    }

    public function getFlash($name = null)
    {
        if (is_null($name)) {
            return array_merge($this->flash, $this->flashNew);
        }

        $value = arr_get($this->flashNew, $name);
        if (!$value) {
            $value = arr_get($this->flash, $name);
        }

        return $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasFlash($name)
    {
        return null !== $this->getFlash($name);
    }

    public function terminate()
    {
        $this->moveNewFlashToFlash();
    }
}
