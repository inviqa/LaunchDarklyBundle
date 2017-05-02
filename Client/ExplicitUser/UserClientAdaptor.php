<?php

namespace Inviqa\LaunchDarklyBundle\Client\ExplicitUser;

use Inviqa\LaunchDarklyBundle\Client\Client;
use Inviqa\LaunchDarklyBundle\Profiler\Context;
use LaunchDarkly\LDUser;

class UserClientAdaptor implements ExplicitUserClient
{
    private $inner;

    public function __construct(Client $inner)
    {
        $this->inner = $inner;
    }    

    public function variation($key, LDUser $user, $default = false, Context $context = null)
    {
        return $this->inner->variation($key, $user, $default, $context);
    }

}
