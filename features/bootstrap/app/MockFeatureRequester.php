<?php

use LaunchDarkly\FeatureRequester;

class MockFeatureRequester implements FeatureRequester
{
    private static $flags;

    public static function setOn($name)
    {
        self::$flags[$name] = true;
    }

    public static function setOff($name)
    {
        self::$flags[$name] = false;
    }

    public function get($key)
    {
        return [
            "name" => $key,
            "key" => $key,
            "on" => self::$flags[$key],
            "salt" => "faslkhfak",
            "variations" => [
                ["value" => self::$flags[$key], "weight" => 100]
            ]
        ];
    }
}
