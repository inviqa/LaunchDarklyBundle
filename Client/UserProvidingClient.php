<?php

namespace Inviqa\LaunchDarklyBundle\Client;

use Inviqa\LaunchDarklyBundle\User\IdProvider;
use LaunchDarkly\LDUser;

class UserProvidingClient extends ClientDecorator implements Client
{
    private $idProvider;

    public function __construct(Client $inner, IdProvider $idProvider)
    {
        $this->idProvider = $idProvider;
        parent::__construct($inner);
    }

    public function isOn($key, $default = false)
    {
        return $this->toggle($key, new LDUser($this->idProvider->userId()), $default);
    }
}