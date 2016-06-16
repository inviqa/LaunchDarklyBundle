<?php

use Inviqa\LaunchDarklyBundle\Client\Client;
use Inviqa\LaunchDarklyBundle\Client\ClientDecorator;
use LaunchDarkly\LDClient;

class LDClientWrapper extends ClientDecorator implements Client
{
    private $inner;
    static public $lastUser;

    public function __construct(LDClient $inner)
    {
        $this->inner = $inner;
    }

    public function getFlag($key, $user, $default = false) {
        self::$lastUser = $user;
        return $this->inner->getFlag($key, $user, $default);
    }

    public function toggle($key, $user, $default = false) {
        self::$lastUser = $user;
        return $this->inner->toggle($key, $user, $default);
    }

    public function isOn($key, $default = false)
    {
        throw new RuntimeException('The LDClient wrapped by this class does not have this method');
    }
}