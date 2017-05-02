<?php

namespace Inviqa\LaunchDarklyBundle\Client\ExplicitUser;

use Inviqa\LaunchDarklyBundle\Profiler\Context;
use LaunchDarkly\LDUser;

interface ExplicitUserClient
{
    public function variation($key, LDUser $user, $default = false, Context $context = null);
    
}