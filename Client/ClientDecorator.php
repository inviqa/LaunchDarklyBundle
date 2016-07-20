<?php

namespace Inviqa\LaunchDarklyBundle\Client;

use Inviqa\LaunchDarklyBundle\Profiler\Context;

abstract class ClientDecorator implements Client
{
    protected $inner;

    public function __construct(Client $inner)
    {
        $this->inner = $inner;
    }

    public function isOn($key, $default = false, Context $context = null)
    {
        return $this->inner->isOn($key, $default, $context);
    }

    public function getFlag($key, $user, $default = false, Context $context = null)
    {
        return $this->inner->getFlag($key, $user, $default, $context);
    }

    public function toggle($key, $user, $default = false, Context $context = null)
    {
        return $this->inner->toggle($key, $user, $default, $context);
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