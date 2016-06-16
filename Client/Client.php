<?php

namespace Inviqa\LaunchDarklyBundle\Client;

interface Client
{
    public function isOn($key, $default = false);
    
    public function getFlag($key, $user, $default = false);

    public function toggle($key, $user, $default = false);

    public function setOffline();

    public function setOnline();

    public function isOffline();

    public function track($eventName, $user, $data);

    public function identify($user);

}