<?php

use LaunchDarkly\FeatureRequester;

class MockFeatureRequester implements FeatureRequester
{
    public static $capacity;
    public static $events;
    public static $defaults;
    private static $flags;
    public static $baseUri;
    public static $apiKey;
    public static $connectTimeout;
    private $options;
    public static $usedForKey = false;
    public static $timeout;

    /**
     * MockFeatureRequester constructor.
     */
    public function __construct($baseUri, $apiKey, $options)
    {
        self::$baseUri = $baseUri;
        self::$apiKey = $apiKey;
        self::$timeout = $options['timeout'];
        self::$connectTimeout = $options['connect_timeout'];
        self::$capacity = $options['capacity'];
        self::$events = isset($options['events']) ? $options['events'] : null;
        self::$defaults = isset($options['defaults']) ? $options['defaults'] : null;
        $this->options = $options;
    }

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
        self::$usedForKey = true;
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
