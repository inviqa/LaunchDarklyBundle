<?php

namespace Inviqa\LaunchDarklyBundle\Client;

use Inviqa\LaunchDarklyBundle\Profiler\Context;
use Inviqa\LaunchDarklyBundle\User\UserFactory;
use Inviqa\LaunchDarklyBundle\User\IdProvider;

class UserProvidingClient implements SimpleClient
{
    private $inner;
    private $idProvider;
    private $userFactory;

    public function __construct(Client $inner, IdProvider $idProvider, UserFactory $userFactory)
    {
        $this->inner = $inner;
        $this->idProvider = $idProvider;
        $this->userFactory = $userFactory;
    }

    public function isOn($key, $default = false, Context $context = null)
    {
        return $this->inner->toggle($key, $this->userFactory->create($this->idProvider->userId()), $default, $context);
    }
}