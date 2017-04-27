<?php

use Inviqa\LaunchDarklyBundle\Client\Client;
use Inviqa\LaunchDarklyBundle\Client\ClientDecorator;
use Inviqa\LaunchDarklyBundle\Profiler\Context;
use LaunchDarkly\LDClient;

class LDClientWrapper extends ClientDecorator implements Client
{
    static public $lastUser;

    public function __construct(LDClient $inner)
    {
        $this->inner = $inner;
    }

    public function getFlag($key, $user, $default = false, Context $context = null) {
        self::$lastUser = $user;
        return $this->inner->getFlag($key, $user, $default);
    }

    public function variation($key, $user, $default = false, Context $context = null) {
        self::$lastUser = $user;
        return $this->inner->variation($key, $user, $default);
    }

}