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

    public function isOn($key, Context $context = null, $default = false)
    {
        return $this->inner->isOn($key, $context, $default);
    }

    public function getFlag($key, $user, Context $context = null, $default = false)
    {
        return $this->inner->getFlag($key, $user, $context, $default);
    }

    public function toggle($key, $user, Context $context = null, $default = false)
    {
        return $this->inner->toggle($key, $user, $context, $default);
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