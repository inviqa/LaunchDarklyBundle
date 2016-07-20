<?php

namespace Inviqa\LaunchDarklyBundle\Client;

use Inviqa\LaunchDarklyBundle\Profiler\Context;
use Inviqa\LaunchDarklyBundle\User\UserFactory;
use Inviqa\LaunchDarklyBundle\User\IdProvider;

class UserProvidingClient extends ClientDecorator implements Client
{
    private $idProvider;
    private $userFactory;

    public function __construct(Client $inner, IdProvider $idProvider, UserFactory $userFactory)
    {
        $this->idProvider = $idProvider;
        $this->userFactory = $userFactory;
        parent::__construct($inner);
    }

    public function isOn($key, Context $context = null, $default = false)
    {
        return $this->toggle($key, $this->userFactory->create($this->idProvider->userId()), $context, $default);
    }
}