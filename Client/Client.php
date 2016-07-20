<?php

namespace Inviqa\LaunchDarklyBundle\Client;

use Inviqa\LaunchDarklyBundle\Profiler\Context;

interface Client
{
    public function isOn($key, Context $context = null, $default = false);
    
    public function getFlag($key, $user, Context $context = null, $default = false);

    public function toggle($key, $user, Context $context = null, $default = false);

    public function setOffline();

    public function setOnline();

    public function isOffline();

    public function track($eventName, $user, $data);

    public function identify($user);

}