<?php

namespace Inviqa\LaunchDarklyBundle\Client;

use Inviqa\LaunchDarklyBundle\Profiler\Context;

interface SimpleClient
{
    public function variation($key, $default = false, Context $context = null);
    
}