<?php

namespace Inviqa\LaunchDarklyBundle\Client;

use Inviqa\LaunchDarklyBundle\User\IdProvider;
use LaunchDarkly\LDUser;

class UserProvidingClient implements Client
{
    private $inner;
    private $idProvider;

    public function __construct(Client $inner, IdProvider $idProvider)
    {
        $this->inner = $inner;
        $this->idProvider = $idProvider;
    }

    public function isOn($key, $default = false)
    {
        return $this->toggle($key, new LDUser($this->idProvider->userId()), $default);
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