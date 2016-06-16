<?php

namespace Inviqa\LaunchDarklyBundle\User;

use LaunchDarkly\LDUser;

class SimpleUserFactory implements UserFactory
{

    public function create($key)
    {
        return new LDUser($key);
    }
    
}