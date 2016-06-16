<?php

use Inviqa\LaunchDarklyBundle\Client\Client;
use LaunchDarkly\LDClient;

class LDClientWrapper implements Client
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

    public function setOffline() {
        $this->inner->setOffline();
    }

    public function setOnline() {
        $this->inner->setOnline();
    }

    public function isOffline() {
        return $this->inner->isOffline();
    }

    public function track($eventName, $user, $data) {
        $this->inner->track($eventName, $user, $data);
    }

    public function identify($user) {
        $this->inner->identify($user);
    }

    public function isOn($key, $default = false)
    {
        throw new RuntimeException('The LDClient wrapped by this class does not have this method');
    }
}