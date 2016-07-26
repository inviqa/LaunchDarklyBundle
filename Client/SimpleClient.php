<?php

namespace Inviqa\LaunchDarklyBundle\Client;

use Inviqa\LaunchDarklyBundle\Profiler\Context;

interface SimpleClient
{
    public function isOn($key, $default = false, Context $context = null);
    
}