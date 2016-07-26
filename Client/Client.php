<?php

namespace Inviqa\LaunchDarklyBundle\Client;

use Inviqa\LaunchDarklyBundle\Profiler\Context;

interface Client
{
    public function getFlag($key, $user, $default = false, Context $context = null);

    public function toggle($key, $user, $default = false, Context $context = null);

    public function setOffline();

    public function setOnline();

    public function isOffline();

    public function track($eventName, $user, $data);

    public function identify($user);

}