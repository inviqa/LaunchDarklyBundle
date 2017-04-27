<?php

namespace Inviqa\LaunchDarklyBundle\Client;

use Inviqa\LaunchDarklyBundle\Profiler\Context;

class StaticClient
{
    private static $client;
    private static $clientProvider;

    public static function setClient(callable $clientProvider)
    {
        self::$clientProvider = $clientProvider;
    }

    public static function variation($key, $default = false, Context $context = null)
    {
        return self::getClient()->variation($key, $default, $context);
    }

    private static function getClient()
    {
        if(!self::$client) {
            $callable = self::$clientProvider;
            $client = $callable();

            if (!$client instanceof SimpleClient) {
                throw new \RuntimeException('The inviqa_launchdarkly.client service should be an instance of Inviqa\LaunchDarklyBundle\Client\SimpleClient');
            }

            self::$client = $client;
        }

        return self::$client;
    }

}