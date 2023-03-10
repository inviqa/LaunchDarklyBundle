<?php

namespace Inviqa\LaunchDarklyBundle\Tests;

use Inviqa\LaunchDarklyBundle\User\UserFactory;
use LaunchDarkly\LDUserBuilder;

class IPUserFactory implements UserFactory
{
    public static $ip;

    public function create($key)
    {
        return (new LDUserBuilder($key))->ip(self::$ip)->build();
    }
    
}
