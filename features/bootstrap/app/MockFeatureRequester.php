<?php

namespace Inviqa\LaunchDarklyBundle\Tests;

use LaunchDarkly\FeatureFlag;
use LaunchDarkly\FeatureRequester;

class MockFeatureRequester implements FeatureRequester
{
    public static $capacity;
    public static $events;
    public static $defaults;
    public static $flags;
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
        self::$flags[$name] = self::getFlag($name, true);
    }

    public static function setOff($name)
    {
        self::$flags[$name] = self::getFlag($name, false);
    }

    private static function getFlag($key, $value)
    {
        self::$usedForKey = true;
        return FeatureFlag::decode([
            "name" => $key,
            "key" => $key,
            "version" => 1,
            "prerequisites" => [],
            "targets" => [],
            "rules" => [],
            "fallthrough" => ["variation" => 0],
            "offVariation" => null,
            "on" => $value,
            "salt" => "faslkhfak",
            "deleted" => false,
            "variations" => [
                ["value" => $value, "weight" => 100]
            ]
        ]);
    }

    /**
     * Gets all features.
     *
     * @return array()|null The decoded FeatureFlags, or null if missing
     */
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function getFeature($key)
    {
        return isset(self::$flags[$key]) ? self::$flags[$key] : null;
    }

    public function getSegment($key)
    {
        return null;
    }

    public function getAllFeatures()
    {
        return self::$flags;
    }
}
