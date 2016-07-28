<?php

namespace Inviqa\LaunchDarklyBundle\Client;

use Inviqa\LaunchDarklyBundle\Profiler\Context;
use Inviqa\LaunchDarklyBundle\User\UserFactory;
use Inviqa\LaunchDarklyBundle\User\KeyProvider;

class UserProvidingClient implements SimpleClient
{
    private $inner;
    private $keyProvider;
    private $userFactory;

    public function __construct(Client $inner, KeyProvider $keyProvider, UserFactory $userFactory)
    {
        $this->inner = $inner;
        $this->keyProvider = $keyProvider;
        $this->userFactory = $userFactory;
    }

    public function isOn($key, $default = false, Context $context = null)
    {
        return $this->inner->toggle($key, $this->userFactory->create($this->keyProvider->userKey()), $default, $context);
    }
}