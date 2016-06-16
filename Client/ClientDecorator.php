<?php

namespace Inviqa\LaunchDarklyBundle\Client;

abstract class ClientDecorator implements Client
{
    private $inner;

    public function __construct(Client $inner)
    {
        $this->inner = $inner;
    }

    public function isOn($key, $default = false)
    {
        return $this->inner->isOn($key, $default);
    }

    public function getFlag($key, $user, $default = false)
    {
        return $this->inner->getFlag($key, $user, $default);
    }

    public function toggle($key, $user, $default = false)
    {
        return $this->inner->toggle($key, $user, $default);
    }

    public function setOffline()
    {
        $this->inner->setOffline();
    }

    public function setOnline()
    {
        $this->inner->setOnline();
    }

    public function isOffline()
    {
        return $this->inner->isOffline();
    }

    public function track($eventName, $user, $data)
    {
        $this->inner->track($eventName, $user, $data);
    }

    public function identify($user)
    {
        $this->inner->identify($user);
    }
}